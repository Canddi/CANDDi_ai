<?php
class Canddi_Service_ProcessType_SessionTest
    extends Canddi_TestCase
{
    public function testGetInputOrOutputItemByType()
    {
        $strAccountURL = "anAccount";
        $mockContact    = Mockery::mock('Canddi_Model_SecondOrder_Contact_Model');

        $strSessionGUID = 'SessionGUID';

        $guidContact    = md5(1);

        $mockSession    = Mockery::mock('Canddi_Model_FirstOrder_Session_Abstract')
            ->shouldReceive('getAccountURL')
            ->times(2)
            ->andReturn($strAccountURL)
            ->shouldReceive('getContactId')
            ->times(2)
            ->andReturn($guidContact)
            ->mock();

        $mockGWContact = Mockery::mock('Canddi_Gateway_Contact')
            ->shouldReceive('getByContactGUID')
            ->times(2)
            ->with($guidContact)
            ->andReturn($mockContact)
            ->mock();

        $mockGateway = Mockery::mock('Canddi_Gateway')
            ->shouldReceive('getContact')
            ->times(2)
            ->with($strAccountURL, true)
            ->andReturn($mockGWContact)
            ->mock();
        Canddi_Gateway::inject($mockGateway);

        $base           = Canddi_Service::getInstance()->getProcess($mockSession);

        $this->assertEquals(
            $base->_getInputItemBySource(Canddi_Model_Local_Process_Input::SOURCE_CONTACT ),
            $mockContact
        );

        try {
            $base->_getInputItemBySource(Canddi_Model_Local_Process_Input::SOURCE_SESSIONGOAL);
            throw new Exception("Test Fails");
        } catch(Canddi_Exception_Fatal_NotImplemented $e) {

        }
        $this->assertEquals(
            $mockSession,
            $base->_getInputItemBySource(Canddi_Model_Local_Process_Input::SOURCE_SESSION)
        );

        $mockHelperCore = Mockery::mock("Canddi_Helper_Response_ProcessSaveToCore")
            ->shouldReceive('getOutputType')
            ->once()
            ->andReturn(Canddi_Service_ProcessType_Abstract::OUTPUT_CONTACT)
            ->mock();


        $this->assertEquals(
            $base->getOutputModelBySaveToTypeAndCores($mockHelperCore),
            $mockContact
        );

        //Now lets try to delete the PPA
        //This shouldn't do anything yet
        $this->_invokeProtMethod($base, "_deletePPA");
    }
}
