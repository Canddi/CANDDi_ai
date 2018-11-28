<?php
/**
 * This stores a single message to be processed later
 * this could be made a singleton but this would complicate
 * its purpose from a storeItem to a semi-storeItems -
 * so it's being left alone
 **/
class Canddi_StoreItem_Message
    extends Canddi_StoreItem_Abstract
{
    private $_strSingletonName;

    private $_message;
    /**
     * Creates using a message
     *
     * @param   Canddi_Message_Abstract the message to save
     * @param   $strSingletonName - unique name if Singleton!
     *
     * @author Tim Langley
     **/
    public function __construct(
        Canddi_Message_Abstract $message,
        $strSingletonName
    ) {
        $this->_message         = $message;
        $this->_strSingletonName= $strSingletonName;
    }
    /**
     * This is the "unique name" for the storeitem
     *
     * @return string
     *
     * @author Tim Langley
     **/
    public function getInstanceName()
    {
        return $this->_strSingletonName;
    }
    /**
     * Processes the storeItem
     *
     * @return $this
     * @author Dan Dart
     **/
    public function process()
    {
        // Let's set the message to be immediately processed
        // and then send it again
        $this->_message->setSendImmediately()->send();
    }
}
