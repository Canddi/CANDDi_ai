<?php
/**
 * Service for Mustache rendering
 *
 * @package default
 * @author Dan Dart
 **/


use CanddiAI\Account\Widget\WidgetAbstract as NS_Widget_Abstract;
use CanddiAI\Account\Widget\Core\IP as NS_Widget_Core_IP;
use CanddiAI\Account\Widget\Core\Referrer as NS_Widget_Core_Referrer;

use CanddiAI\Message\TriggerAction\AbstractTriggerAction as
    NS_MessageTriggerAction_AbstractTriggerAction;

class Canddi_Service_Mustache
    implements Canddi_Interface_Singleton
{
    use Canddi_Traits_Singleton;

    private $_serviceMustache;

    /**
     * This allows us to configure the instance
     * when first loads
     * Override in children
     *
     **/
    protected function _postInstance()
    {
        $this->_serviceMustache     = new \Phly\Mustache\Mustache();
    }
    /**
     * Renders the mustache as best we can
     *
     * @param Array $arrParams
     * @return string
     *
     * @author Dan Dart
     **/
    public function render(
        $strTemplate,
        Array $arrParams
    )
    {
        // If no mustaches exist...
        // BE CAREFUL NOT TO INCLUDE MUSTACHES ACCIDENTALLY!
        if (false === strstr($strTemplate, '{{')) {
            return $strTemplate;
        }

        if (empty($arrParams)) {
            return $strTemplate;
        }

        try {
            // If we can render it - do so
            return $this->_serviceMustache->render($strTemplate, $arrParams);
        } catch (\Phly\Mustache\Exception\TemplateNotFoundException $e) {
            // We get this exception when there's no real mustaches -
            // make sure here we get something sensible
            return $strTemplate;
        }
    }
    /**
     * Mustachifies the text for subject and title
     *
     * @return string
     *
     * @author Tim Langley
     **/
    public function renderNotification(
        Canddi_Model_SecondOrder_Contact_Model $modelContact,
        $strTriggerType,
        $strTemplate
    ) {
        $strCity            = "";
        $strCountry         = "";
        $strSubType         = "";
        $strRegion          = "";

        $strAssignedTo      = $modelContact->getAssignedTo();
        if(!empty($strAssignedTo)) {
            try {
                $strAssignedTo= Canddi_Gateway::getInstance()
                    ->getAccountUser()
                    ->getByEmailAddress($strAssignedTo)
                    ->getName();
            } catch(Exception $e) {
               $strAssignedTo  = "";
            }
        }

        try {
            //Firstly - what if the widget isn't defined
            //  this should never happen but ....
            $modelAccountWidget     = $modelContact->getWidgets()
                ->seek(NS_Widget_Core_IP::ID);
            //Secondly - what happens if there are NO IP Lookups
            //  this will "probably" never happen
            $ittContactWidgets      = $modelAccountWidget
                ->getContactWidgets()
                ->sort([Canddi_Model_SecondOrder_Contact_Model_AccountWidget_ContactWidget::FIELD_DATE_TimeCreated => Canddi_Iterator_Interface::SORT_DESC]);
                $modelContactWidget     = $ittContactWidgets->current();

            $arrData                = $modelContactWidget->getData();

            $strCity                = isset($arrData[NS_Widget_Core_IP::FIELD_City])?
                                            $arrData[NS_Widget_Core_IP::FIELD_City]:
                                            "";

            $strCountry             = isset($arrData[NS_Widget_Core_IP::FIELD_Country])?
                                            $arrData[NS_Widget_Core_IP::FIELD_Country]:
                                            "";

            $strRegion              = isset($arrData[NS_Widget_Core_IP::FIELD_Region])?
                                            $arrData[NS_Widget_Core_IP::FIELD_Region]:
                                            "";
        } catch(Exception $e) {
            //TBH don't really care about any errors here
            // ignore them - we;ll worry later
        }

        try {
            //Firstly - what if the widget isn't defined
            //  this should never happen but ....
            $modelAccountWidget     = $modelContact->getWidgets()
                ->seek(NS_Widget_Core_Referrer::ID);
            //Secondly - what happens if there are NO Referrers
            //  this will "probably" never happen
            $ittContactWidgets      = $modelAccountWidget
                ->getContactWidgets()
                ->sort([Canddi_Model_SecondOrder_Contact_Model_AccountWidget_ContactWidget::FIELD_DATE_TimeCreated => Canddi_Iterator_Interface::SORT_DESC]);
                $modelContactWidget     = $ittContactWidgets->current();

            $arrData                = $modelContactWidget->getData();

            $strSubType             = isset($arrData[NS_Widget_Core_Referrer::AWFIELD_ReferrerSubType])?
                                            $arrData[NS_Widget_Core_Referrer::AWFIELD_ReferrerSubType]:
                                            "";
        } catch(Exception $e) {
            //TBH don't really care about any errors here
            // ignore them - we;ll worry later
        }

        $modelCompanyChild = $modelContact->getPrimaryCompany();
        try {
            $modelCompany = Canddi_Gateway::getInstance()
                ->getCompany($modelContact->getAccountURL())
                ->getByGUID($modelCompanyChild->getCId());
            $strCompanyName = $modelCompany->getCompanyName();
        } catch (Canddi_Exception_Fatal_DaoItemNotFound $e){
            $strCompanyName = null;
        }
        $arrMustache        = [
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_ASSIGNED
                => $strAssignedTo,
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_CITY
                => $strCity,
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_COUNTRYNAME
                => $strCountry,
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_EMAIL
                => $modelContact->getPrimaryEmail()->getEmail(),
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_FULLNAME
                => $modelContact->getPrimaryName()->getFullName(),
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_LEADGRADE
                => $modelContact->getLeadGrade(),
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_LEADSCORE
                => $modelContact->getLeadScore(),
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_COMPANYNAME
                => $strCompanyName,
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_LINK
                => $modelContact->getDashboardURL(),
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_SUBTYPE
                => $strSubType,
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_TOTAL_ACTIVITIES
                => $modelContact->getCountSessionGoals(),
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_TOTAL_DURATION
                => $modelContact->getTotalDuration(),
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_TOTAL_VISITS
                => $modelContact->getCountSessions(),
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_TRIGGERTYPE
                => $strTriggerType,
            NS_MessageTriggerAction_AbstractTriggerAction::TEMPLATE_REGION
                => $strRegion
        ];

        return $this->render($strTemplate, $arrMustache);
    }
}
