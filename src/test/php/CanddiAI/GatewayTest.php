<?php
/**
 * @category
 * @package
 * @copyright  2011-06-05 (c) 2011 Campaign and Digital Intelligence (http://canddi.com)
 * @license
 * @author     Oli Wood
 **/

class Canddi_GatewayTest extends Canddi_TestCase
{
    public function _postSetup()
    {
        //This is silly it's the Gateway therefore we actually need this
        Canddi_Gateway::inject(null);
    }
    public function testGetInstance()
    {
        $this->assertTrue(Canddi_Gateway::getInstance() instanceof Canddi_Gateway);
    }
    public function testgetCapturePreviews()
    {
        $strAccountURL      = "anAccount";
        $gateway            = Canddi_Gateway::getInstance();
        $this->assertTrue(
            $gateway->getCapturePreviews($strAccountURL) instanceof Canddi_Gateway_Module_CaptureNew_CapturePreviews
        );
    }
    public function testgetCaptureWidgets()
    {
        $strAccountURL      = "anAccount";
        $gateway            = Canddi_Gateway::getInstance();
        $this->assertTrue(
            $gateway->getCaptureWidgets($strAccountURL) instanceof Canddi_Gateway_Module_CaptureNew_CaptureWidgets
        );
    }
    public function testGetContactCRM()
    {
        $strAccountURL      = "anAccount";
        $gateway            = Canddi_Gateway::getInstance();
        $this->assertTrue(
            $gateway->getContactCRM($strAccountURL) instanceof Canddi_Gateway_ContactCRM
        );
    }
    public function testGetContactWidget_Unknown()
    {
        $this->setExpectedException("Canddi_Exception_Fatal_InvalidValue");

        $strAccountURL      = "anAccount";
        $strType            = "INVALID";
        $gateway            = Canddi_Gateway::getInstance();
        $this->assertTrue(
            $gateway->getContactWidget($strAccountURL, $strType) instanceof Canddi_Gateway_ContactWidget_LeadScore
        );
    }
    public function testGetContactWidget_LeadScore()
    {
        $strAccountURL      = "anAccount";
        $strType            = Canddi_Model_SecondOrder_Contact_Widgets_LeadScore::TYPE;
        $gateway            = Canddi_Gateway::getInstance();
        $this->assertTrue(
            $gateway->getContactWidget($strAccountURL, $strType) instanceof Canddi_Gateway_ContactWidget_LeadScore
        );
    }
    public function testGetEmailPlugin()
    {
        $strAccountURL      = "anAccount";
        $gateway            = Canddi_Gateway::getInstance();
        $this->assertTrue(
            $gateway->getEmailPlugin($strAccountURL) instanceof Canddi_Gateway_EmailPlugin
        );
    }
    public function testGetGDPRAudit()
    {
        $strAccountURL      = "anAccount";
        $gateway            = Canddi_Gateway::getInstance();
        $this->assertInstanceOf(
            Canddi_Gateway_Module_GDPR_Audit::class,
            $gateway->getGDPRAudit($strAccountURL)
        );
    }
    public function testGetGDPRBlocked()
    {
        $strAccountURL      = "anAccount";
        $gateway            = Canddi_Gateway::getInstance();
        $this->assertInstanceOf(
            Canddi_Gateway_Module_GDPR_Blocked::class,
            $gateway->getGDPRBlocked($strAccountURL)
        );
    }
    public function testGetRateLimit()
    {
        $strAccountURL  = "anAccount";
        $gateway        = Canddi_Gateway::getInstance();

        $this->assertTrue(
            $gateway->getRateLimit($strAccountURL) instanceof Canddi_Gateway_RateLimit
        );
    }
    public function testGetScore()
    {
        $gateway            = Canddi_Gateway::getInstance();
        $this->assertTrue(
            $gateway->getScore() instanceof Canddi_Gateway_Module_Score
        );
    }
    public function testGetSearchContacts()
    {
        $strAccountURL      = "anAccount";
        $gateway            = Canddi_Gateway::getInstance();
        $response           = $gateway->getSearchContacts($strAccountURL);
        $this->assertTrue(
            $response instanceof Canddi\Gateway\Search\Contacts
        );
    }
    public function testGetStream()
    {
        $strAccountURL      = "anAccount";
        $gateway            = Canddi_Gateway::getInstance();
        $this->assertTrue(
            $gateway->getStream($strAccountURL) instanceof Canddi_Gateway_Stream
        );
    }
    public function testGetTrackerGoal_Invalid()
    {
        $this->setExpectedException("Canddi_Exception_Fatal_InvalidValue");
        $strAccountURL  = "anAccount";
        $intTrackerType = -1;
        $gateway        = Canddi_Gateway::getInstance();

        $this->assertTrue(
            $gateway->getTrackerGoal($strAccountURL, $intTrackerType)
                instanceof Canddi_Gateway_TrackerGoal_Website
        );
    }
    public function testGetTrackerGoal_Website()
    {
        $strAccountURL  = "anAccount";
        $intTrackerType = Canddi_Helper_TrackerType::ID_WEBSITE;
        $gateway        = Canddi_Gateway::getInstance();

        $this->assertTrue(
            $gateway->getTrackerGoal($strAccountURL, $intTrackerType)
                instanceof Canddi_Gateway_TrackerGoal_Website
        );
    }
    public function testGetTrackerGoal_Questions()
    {
        $strAccountURL  = "anAccount";
        $intTrackerType = Canddi_Helper_TrackerType::ID_QUESTIONS;
        $gateway        = Canddi_Gateway::getInstance();

        $this->assertTrue(
            $gateway->getTrackerGoal($strAccountURL, $intTrackerType)
                instanceof Canddi_Gateway_TrackerGoal_Questions
        );
    }
    public function testGetTrackerGoal_Phone()
    {
        $strAccountURL  = "anAccount";
        $intTrackerType = Canddi_Helper_TrackerType::ID_PHONE;
        $gateway        = Canddi_Gateway::getInstance();

        $this->assertTrue(
            $gateway->getTrackerGoal($strAccountURL, $intTrackerType)
                instanceof Canddi_Gateway_TrackerGoal_Phone
        );
    }
    public function testGetTrackerGoal_Manual()
    {
        $strAccountURL  = "anAccount";
        $intTrackerType = Canddi_Helper_TrackerType::ID_MANUAL;
        $gateway        = Canddi_Gateway::getInstance();

        $this->assertTrue(
            $gateway->getTrackerGoal($strAccountURL, $intTrackerType)
                instanceof Canddi_Gateway_TrackerGoal_Manual
        );
    }
}
