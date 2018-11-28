<?php
class Canddi_Service_ProcessType_Contact
    extends Canddi_Service_ProcessType_Abstract
{
    private $_modelContact;

    /**
     * Creates a Process Contact
     *
     * @author Dan Dart
     **/
    public static function create(
        Canddi_Model_SecondOrder_Contact_Model $modelContact,
        Canddi_Iterator_Cores $coreItems = null,
        $bSendTriggers = true
    ) {
        $ppaContact     = new Canddi_Service_ProcessType_Contact(
            $coreItems,
            $bSendTriggers
        );
        $ppaContact->_modelContact  = $modelContact;
        return $ppaContact;
    }
    /**
     * This deletes the PPA
     * This is used in instances where one of the PPA conditions has
     * fatally failed (example a CRM Connection being deleted)
     *
     * This is different for each type hence abstract
    **/
    protected function _deletePPA($mixedPPAId)
    {
        //This needs to load the ModelAccount
        //Delete the Process function
        //Throw a "save Account message"
        $gwAccount      = Canddi_Gateway::getInstance()->getAccount();

        $modelAccount   = $gwAccount->getById($this->_getAccountURL());
        //Now we search for the PPA
        try {
            $modelAccount
                ->getContactProcessActions()
                ->seek($mixedPPAId)
                ->removeChild();
        } catch (Canddi_Exception_Fatal_ItemNotInIterator $e) {
            Canddi_Helper_Log::getInstance()->log(
                "Unable to delete $mixedPPAId - not found on model"
            );
            return;
        }

        $gwAccount->save($modelAccount);
        return;
    }
    protected function _getAccountURL()
    {
        return $this->_modelContact->getAccountURL();
    }
    protected function _getBaseInputName()
    {
        return Canddi_Service_ProcessType_Abstract::PF_INPUT_CONTACT;
    }
    protected function _getBaseModel()
    {
        return $this->_modelContact;
    }
    protected function _getContactId()
    {
        return $this->_modelContact->getId();
    }
    protected function _getModelContact()
    {
        return $this->_modelContact;
    }
    protected function _getModelSession()
    {
        throw new Canddi_Exception_Fatal_NotImplemented(__METHOD__);
    }
    protected function _getModelSessionGoal()
    {
        throw new Canddi_Exception_Fatal_NotImplemented(__METHOD__);
    }
    protected function _saveBaseModel($bSendTriggers = true)
    {
        Canddi_Gateway::getInstance()
            ->getContact(
                $this->_getAccountURL(),
                $bSendTriggers
            )
            ->save(
                $this->_modelContact,
                true,
                $bSendTriggers
            );
    }
}
