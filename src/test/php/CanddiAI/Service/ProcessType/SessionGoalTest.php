<?php

use Canddi\ProcessFunction\FieldTo\Email as NS_ProcessFunction_FieldTo_Email;

class Canddi_Service_ProcessType_SessionGoalTest
    extends Canddi_TestCase
{
    public function testGetInputOrOutputItemByType()
    {
        $strAccountURL = "anAccount";
        $mockContact = Mockery::mock('Canddi_Model_SecondOrder_Contact_Model');

        $strSessionGUID = 'SessionGUID';

        $guidContact    = md5(1);
        $guidTG         = md5(2);
        $guidT          = md5(3);
        $strURL         = "http://testurl.com/";

        $mockSession    = Mockery::mock('Canddi_Model_FirstOrder_Session_Website');

        $intPageType    = Canddi_Helper_TrackerType::ID_WEBSITE;

        $mockSessionGoal = Mockery::mock('Canddi_Model_FirstOrder_SessionGoal_Website')
            ->shouldReceive('getAccountURL')
            ->times(3)
            ->andReturn($strAccountURL)
            ->shouldReceive('getContactId')
            ->times(2)
            ->andReturn($guidContact)
            ->shouldReceive('getSessionGUID')
            ->times(1)
            ->andReturn($strSessionGUID)
            ->mock();

        $mockGWContact = Mockery::mock('Canddi_Gateway_Contact')
            ->shouldReceive('getByContactGUID')
            ->times(2)
            ->with($guidContact)
            ->andReturn($mockContact)
            ->mock();

        $mockGwSession = Mockery::mock('Canddi_Gateway_Session')
            ->shouldReceive('getById')
            ->times(1)
            ->with($strSessionGUID)
            ->andReturn($mockSession)
            ->mock();

        $mockTG            = Mockery::mock('Canddi_Model_Local_TrackerGoal_Website_Abstract');

        $mockGateway = Mockery::mock('Canddi_Gateway')
            ->shouldReceive('getContact')
            ->times(2)
            ->with($strAccountURL, true)
            ->andReturn($mockGWContact)
            ->shouldReceive('getSession')
            ->with($strAccountURL)
            ->times(1)
            ->andReturn($mockGwSession)
            ->mock();
        Canddi_Gateway::inject($mockGateway);

        $base           = Canddi_Service::getInstance()->getProcess($mockSessionGoal);

        $this->assertSame(
            $base->_getInputItemBySource(Canddi_Model_Local_Process_Input::SOURCE_CONTACT ),
            $mockContact
        );
        $this->assertSame(
            $base->_getInputItemBySource(Canddi_Model_Local_Process_Input::SOURCE_SESSIONGOAL),
            $mockSessionGoal
        );
        $this->assertSame(
            $base->_getInputItemBySource(Canddi_Model_Local_Process_Input::SOURCE_SESSION),
            $mockSession
        );

        $mockHelperCore = Mockery::mock("Canddi_Helper_Response_ProcessSaveToCore")
            ->shouldReceive('getOutputType')
            ->once()
            ->andReturn(Canddi_Service_ProcessType_Abstract::OUTPUT_CONTACT)
            ->mock();

        $this->assertSame(
            $base->getOutputModelBySaveToTypeAndCores($mockHelperCore),
            $mockContact
        );

        //Now lets try to delete the PPA
        //This shouldn't do anything yet
        $this->_invokeProtMethod($base, "_deletePPA");
    }
    public function testProcessPPAs_Works()
    {
        $strAccountURL      = "Test";
        $guidContact        = md5(1);
        $bAdd               = true;
        $guidSessionGoal    = md5(2);

        $mockParams         = Mockery::mock("Canddi_Model_Local_Process_Params_Action");

        $mockOutput_NoName  = Mockery::mock("Canddi_Model_Local_Process_Output")
            ->shouldReceive('getName')
            ->once()
            ->andReturn("")
            ->mock();

        $strOutputName        = "OutputName";

        $mockOutput_WithName  = Mockery::mock("Canddi_Model_Local_Process_Output")
            ->shouldReceive('getName')
            ->once()
            ->andReturn($strOutputName)
            ->shouldReceive('getType')
            ->once()
            ->andReturn("IP")
            ->mock();

        $mockOutputs        = Mockery::mock("Canddi_Iterator_Model_Child_Index");
        $mockOutputs
            ->shouldReceive('next')
            ->times(2)
            ->andReturn($mockOutputs)
            ->shouldReceive('current')
            ->times(2)
            ->andReturn($mockOutput_NoName, $mockOutput_WithName)
            ->shouldReceive('valid')
            ->times(3)
            ->andReturn(true, true, false)
            ->shouldReceive('rewind')
            ->once()
            ->mock();

        //NOTE No Inputs in here
        $mockInputs         = Mockery::mock("Canddi_Iterator_Interface")
            ->shouldReceive('rewind')
            ->once()
            ->shouldReceive('valid')
            ->once()
            ->andReturn(false)
            ->mock();

        $arrDependencies_1  = [];

        $intQualityScoreResponse = 1;
        $strEmailAddress    = "tim@canddi.com";
        $mockCoreEmail      = Canddi_Core_Email::create($strEmailAddress);

        $arrCores           = [
            [
                "Core"      =>  $mockCoreEmail,
                "bDelete"   =>  false,
                "bManual"   =>  false
            ]
        ];

        $mockResult         = Mockery::mock("Canddi_Iterator_Process_Result")
            ->shouldReceive('getCoreItemByOutput')
            ->once()
            ->with("IP")
            ->andReturn($arrCores[0])
            ->shouldReceive('getCores')
            ->once()
            ->andReturn($arrCores)
            ->shouldReceive('intQualityScoreResponse')
            ->times(1)
            ->andReturn($intQualityScoreResponse)
            ->mock();
        $mockPF             = Mockery::mock(NS_ProcessFunction_FieldTo_Email::CLASS)
            ->shouldReceive('transform')
            ->once()
            ->with(Mockery::type("Canddi_Iterator_Interface"), $mockParams)
            ->andReturn($mockResult)
            ->mock();
        $mockPPA_1          = Mockery::mock("Canddi_Model_Local_Process_Action_Abstract")
            ->shouldReceive('getFunction')
            ->once()
            ->andReturn($mockPF)
            ->shouldReceive('getInputs')
            ->once()
            ->andReturn($mockInputs)
            ->shouldReceive('getParams')
            ->once()
            ->andReturn($mockParams)
            ->shouldReceive('getOutputs')
            ->once()
            ->andReturn($mockOutputs)
            ->shouldReceive('bCanSaveMultiple')
            ->once()
            ->andReturn(false)
            ->mock();

        $ittMockCompany    = Mockery::mock("Canddi_Iterator_Interface");
        $mockContact        = Mockery::mock("Canddi_Model_SecondOrder_Contact_Model")
            ->shouldReceive('getContactId')
            ->times(1)
            ->andReturn($guidContact)
            ->shouldReceive('getLastSessionGoalId')
            ->once()
            ->andReturn($guidSessionGoal)
            ->shouldReceive('getCompanies')
            ->once()
            ->andReturn($ittMockCompany)
            ->shouldReceive('updateFromCore')
            ->once()
            ->with(
                Mockery::type("Canddi_Helper_Response_ProcessSaveToCore"),
                $guidContact,
                true
            )
            ->mock();

        $mockProcessDeps    = Mockery::mock("Canddi_Iterator_Process_Handler")
            ->shouldReceive('count')
            ->once()
            ->andReturn(1)
            ->shouldReceive('logAppropriately')
            ->once()
            //We call getNext twice in this test
            ->shouldReceive('getNext')
            ->once()
            ->andReturn($mockPPA_1)
            ->shouldReceive('getNext')
            ->once()
            ->andReturn(null)
            ->shouldReceive('setOK')
            ->once()
            ->mock();


        $mockItems          = Mockery::mock("Canddi_Iterator_Cores")
            ->shouldReceive('addCoreItem')
            ->times(1)
            ->with($strOutputName, $mockCoreEmail, $bAdd)
            ->mock();

        $mockSessionGoal    = Mockery::mock("Canddi_Model_FirstOrder_SessionGoal_Website")
            ->shouldReceive('getAccountURL')
            ->times(5)
            ->andReturn($strAccountURL)
            ->shouldReceive('getId')
            ->times(1)
            ->andReturn($guidSessionGoal)
            ->shouldReceive('bHasPPARun')
            ->once()
            ->with($mockPPA_1)
            ->andReturn(false)
            ->shouldReceive('setPPASuccess')
            ->once()
            ->andReturn($mockPPA_1)
            ->shouldReceive('getContactId')
            ->times(3)
            ->andReturn($guidContact)
            ->mock();

        $gwContact = Mockery::mock("Canddi_Gateway_Contact")
            ->shouldReceive('getByContactGUID')
            ->times(2)
            ->with($guidContact)
            ->andReturn($mockContact)
            ->shouldReceive('updateSummaryData')
            ->times(1)
            ->with(
                $guidContact,
                $ittMockCompany,
                "",
                $mockSessionGoal,
                0,
                0,
                0,
                0
            )
            ->shouldReceive('save')
            ->once()
            ->with($mockContact, true, true)
            ->andReturn($mockContact)
            ->mock();

        $gwSessionGoal = Mockery::mock("Canddi_Gateway_SessionGoal")
            ->shouldReceive('save')
            ->once()
            ->with($mockSessionGoal)
            ->andReturn($mockSessionGoal)
            ->mock();

        $mockGateway    = Mockery::mock("Canddi_Gateway")
            ->shouldReceive('getContact')
            ->times(4)
            ->with($strAccountURL, true)
            ->andReturn($gwContact)
            ->shouldReceive('getSessionGoal')
            ->times(1)
            ->with($strAccountURL)
            ->andReturn($gwSessionGoal)
            ->mock();

        Canddi_Gateway::inject($mockGateway);

        $processSessionGoal = Canddi_Service_ProcessType_SessionGoal::create($mockSessionGoal, $mockItems);

        $intResponse        = $processSessionGoal->processPPAs($mockProcessDeps);
        $this->assertEquals(2, $intResponse);
    }
}
