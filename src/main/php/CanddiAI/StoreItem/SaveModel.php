<?php
/**
 *
 *
**/
class Canddi_StoreItem_SaveModel
    extends Canddi_StoreItem_Abstract
{
    private $_gwGateway;
    private $_modelModel;

    /**
     * Creates using a message
     *
     * @param   Canddi_Gateway_Abstract $gwGateway
     * @param   Canddi_Model_Abstract   $modelModel
     *
     * @author Tim Langley
     **/
    public function __construct(
        Canddi_Model_Abstract   $modelModel,
        Canddi_Gateway_Abstract $gwGateway
    ) {
        $this->_gwGateway = $gwGateway;
        $this->_modelModel= $modelModel;
    }
    /**
     * This is a Singleton based on Gateway / ModelId
     *
     * @return string
     *
     * @author Tim Langley
     **/
    public function getInstanceName() {
        return get_class($this->_gwGateway).'-'.$this->_modelModel->getId();
    }
    /**
     * This calls the actual save
     *
     * @author Tim Langley
     **/
    public function process()
    {
        // Let's set the message to be immediately processed
        // and then send it again
        $this->_gwGateway->save($this->_modelModel);
    }
}
