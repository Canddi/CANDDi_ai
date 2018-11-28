<?php
class Canddi_Service_ProcessType_ContactTest
    extends Canddi_TestCase
{
    public function testGetInputOrOutputItemByType()
    {
        $strAccountURL = "anAccount";
        $mockContact    = Mockery::mock('Canddi_Model_SecondOrder_Contact_Model');

        $base           = Canddi_Service::getInstance()->getProcess($mockContact);

        $this->assertEquals(
            $base->_getInputItemBySource(Canddi_Model_Local_Process_Input::SOURCE_CONTACT ),
            $mockContact
        );

        try {
            $base->_getInputItemBySource(Canddi_Model_Local_Process_Input::SOURCE_SESSIONGOAL);
            throw new Exception("Test Fails");
        } catch(Canddi_Exception_Fatal_NotImplemented $e) {

        }
        try {
            $base->_getInputItemBySource(Canddi_Model_Local_Process_Input::SOURCE_SESSION);
            throw new Exception("Test Fails");
        } catch(Canddi_Exception_Fatal_NotImplemented $e) {

        }
        try {
            $base->_getInputItemBySource("RUBBISH");
            throw new Exception("Test Fails");
        } catch(Canddi_Exception_Fatal_InvalidType $e) {

        }

        $mockHelper     = Mockery::mock("Canddi_Helper_Response_ProcessSaveToCore")
            ->shouldReceive('getOutputType')
            ->once()
            ->andReturn(Canddi_Service_ProcessType_Abstract::OUTPUT_CONTACT)
            ->mock();
        $this->assertEquals(
            $base->getOutputModelBySaveToTypeAndCores($mockHelper),
            $mockContact
        );

        $mockHelperCore = Mockery::mock("Canddi_Helper_Response_ProcessSaveToCore")
            ->shouldReceive('getOutputType')
            ->once()
            ->andReturn(Canddi_Service_ProcessType_Abstract::OUTPUT_CONTACT_WIDGETDATA)
            ->shouldReceive('getCoreClass')
            ->once()
            ->andReturn("Canddi_Core_LeadScore")
            ->mock();

        $return     = $base->getOutputModelBySaveToTypeAndCores(
            $mockHelperCore
        );
        $this->assertTrue($return instanceOf Canddi_Model_SecondOrder_Contact_Widgets_LeadScore);
    }
    public function testDeletePPA_PPANotExists()
    {
        $strAccountURL  = "anAccount";
        $mockContact    = Mockery::mock('Canddi_Model_SecondOrder_Contact_Model')
            ->shouldReceive('getAccountURL')
            ->times(1)
            ->andReturn($strAccountURL)
            ->mock();

        $mixedPPAIdNotExisting = "NotExisting";
        $ittContactPPAs = Mockery::mock("Canddi_Iterator_Interface")
            ->shouldReceive('seek')
            ->times(1)
            ->with($mixedPPAIdNotExisting)
            ->andThrow("Canddi_Exception_Fatal_ItemNotInIterator")
            ->mock();

        $mockAccount    = Mockery::mock('Canddi_Model_Canddi_Account')
            ->shouldReceive('getContactProcessActions')
            ->times(1)
            ->andReturn($ittContactPPAs)
            ->mock();

        $mockGWAccount  = Mockery::mock('Canddi_Gateway_Account')
            ->shouldReceive('getById')
            ->times(1)
            ->with($strAccountURL)
            ->andReturn($mockAccount)
            ->mock();

        $mockGateway = Mockery::mock('Canddi_Gateway')
            ->shouldReceive('getAccount')
            ->times(1)
            ->andReturn($mockGWAccount)
            ->mock();
        Canddi_Gateway::inject($mockGateway);

        $base           = Canddi_Service::getInstance()->getProcess($mockContact);

        //Now lets try to delete the PPA - Which doesnt exist!
        $this->_invokeProtMethod($base, "_deletePPA", $mixedPPAIdNotExisting);
    }
    public function testDeletePPA()
    {
        $strAccountURL  = "anAccount";
        $mockContact    = Mockery::mock('Canddi_Model_SecondOrder_Contact_Model')
            ->shouldReceive('getAccountURL')
            ->times(1)
            ->andReturn($strAccountURL)
            ->mock();

        $mixedPPAIdNotExisting = "PPA_Exists";

        $mockPPA        = Mockery::mock("Canddi_Model_Local_Process_Action_Contact")
            ->shouldReceive('removeChild')
            ->times(1)
            ->mock();

        $ittContactPPAs = Mockery::mock("Canddi_Iterator_Interface")
            ->shouldReceive('seek')
            ->times(1)
            ->with($mixedPPAIdNotExisting)
            ->andReturn($mockPPA)
            ->mock();

        $mockAccount    = Mockery::mock('Canddi_Model_Canddi_Account')
            ->shouldReceive('getContactProcessActions')
            ->times(1)
            ->andReturn($ittContactPPAs)
            ->mock();

        $mockGWAccount  = Mockery::mock('Canddi_Gateway_Account')
            ->shouldReceive('getById')
            ->times(1)
            ->with($strAccountURL)
            ->andReturn($mockAccount)
            ->shouldReceive('save')
            ->times(1)
            ->with($mockAccount)
            ->andReturn($mockAccount)
            ->mock();

        $mockGateway = Mockery::mock('Canddi_Gateway')
            ->shouldReceive('getAccount')
            ->times(1)
            ->andReturn($mockGWAccount)
            ->mock();
        Canddi_Gateway::inject($mockGateway);

        $base           = Canddi_Service::getInstance()->getProcess($mockContact);

        //Now lets try to delete the PPA - Which doesnt exist!
        $this->_invokeProtMethod($base, "_deletePPA", $mixedPPAIdNotExisting);
    }
}
