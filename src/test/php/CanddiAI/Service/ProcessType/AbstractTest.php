<?php

use Canddi\ProcessFunction\FunctionAbstract as NS_ProcessFunction_FunctionAbstract;

class Canddi_Service_ProcessFunction_Test_Internal
    extends NS_ProcessFunction_FunctionAbstract
{
    const TYPE      = 'Test_Internal';
    public function transform(
        Canddi_Iterator_Cores $coreItems,
        Canddi_Model_Local_Process_Params_Action $modelParams
    )
    {
        $coreText   = Canddi_Core_Empty::create();
        $result     = new Canddi_Iterator_Process_Result();

        $result->addCore($coreText, false, false);
        return $result;
    }
}
class Canddi_Service_ProcessFunction_Test_InternalError
    extends NS_ProcessFunction_FunctionAbstract
{
    const TYPE      = 'Test_InternalError';
    public function transform(
        Canddi_Iterator_Cores $coreItems,
        Canddi_Model_Local_Process_Params_Action $modelParams
    )
    {
        throw new Canddi_Exception_Fatal_NotImplemented(__METHOD__);
    }
}
class Canddi_Service_ProcessFunction_Test_InternalNotice
    extends NS_ProcessFunction_FunctionAbstract
{
    const TYPE      = 'Test_InternalNotice';
    public function transform(
        Canddi_Iterator_Cores $coreItems,
        Canddi_Model_Local_Process_Params_Action $modelParams
    ) {
        throw new Canddi_Exception_Notice_CannotCreate(__METHOD__);
    }
}

class Canddi_Service_ProcessType_AbstractTest
    extends Canddi_TestCase
{
    public function testProcessPPAs_EmptyItts()
    {
        $mockContact        = Mockery::mock("Canddi_Model_SecondOrder_Contact_Model");

        $mockItems          = Mockery::mock("Canddi_Iterator_Cores");

        $mockProcessDeps    = Mockery::mock("Canddi_Iterator_Process_Handler")
            ->shouldReceive('count')
            ->once()
            ->andReturn(0)
            ->mock();

        $processContact     = Canddi_Service_ProcessType_Contact::create($mockContact, $mockItems);

        $intResponse        = $processContact->processPPAs($mockProcessDeps);
        $this->assertEquals(1, $intResponse);
    }
    public function testProcessPPAs_ThrowsError()
    {
        $strAccountURL      = "Test";

        $mockItems          = Mockery::mock("Canddi_Iterator_Cores");

        $mockContact        = Mockery::mock("Canddi_Model_SecondOrder_Contact_Model");

        $mockParams         = Mockery::mock("Canddi_Model_Local_Process_Params_Action");

        //NOTE No Inputs in here
        $mockInputs         = Mockery::mock("Canddi_Iterator_Interface")
            ->shouldReceive('rewind')
            ->once()
            ->shouldReceive('valid')
            ->once()
            ->andReturn(false)
            ->mock();

        $mockPF             = new Canddi_Service_ProcessFunction_Test_InternalError($strAccountURL);
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
            ->shouldReceive('setError')
            ->once()
            ->with($mockPPA_1, Mockery::Type("Canddi_Exception_Fatal_NotImplemented"))
            ->mock();

        $processContact     = Canddi_Service_ProcessType_Contact::create($mockContact, $mockItems);

        $intResponse        = $processContact->processPPAs($mockProcessDeps);
        $this->assertEquals(2, $intResponse);
    }
    public function testProcessPPAs_ThrowsNotice()
    {
        $strAccountURL      = "Test";

        $mockItems          = Mockery::mock("Canddi_Iterator_Cores");

        $mockContact        = Mockery::mock("Canddi_Model_SecondOrder_Contact_Model");

        $mockParams         = Mockery::mock("Canddi_Model_Local_Process_Params_Action");

        //NOTE No Inputs in here
        $mockInputs         = Mockery::mock("Canddi_Iterator_Interface")
            ->shouldReceive('rewind')
            ->once()
            ->shouldReceive('valid')
            ->once()
            ->andReturn(false)
            ->mock();

        $mockPF             = new Canddi_Service_ProcessFunction_Test_InternalNotice($strAccountURL);
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
            ->shouldReceive('setNotice')
            ->once()
            ->with($mockPPA_1, Mockery::Type("Canddi_Exception_Notice_CannotCreate"))
            ->mock();

        $processContact     = Canddi_Service_ProcessType_Contact::create($mockContact, $mockItems);

        $intResponse        = $processContact->processPPAs($mockProcessDeps);
        $this->assertEquals(2, $intResponse);
    }
    public function testProcessPPAs_Works()
    {
        $strAccountURL      = "Test";

        $mockItems          = Mockery::mock("Canddi_Iterator_Cores");

        $mockParams         = Mockery::mock("Canddi_Model_Local_Process_Params_Action");

        $mockOutputs        = Mockery::mock("Canddi_Iterator_Model_Child_Index")
            ->shouldReceive('rewind')
            ->once()
            ->shouldReceive('valid')
            ->once()
            ->andReturn(false)
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
        $mockPF             = new Canddi_Service_ProcessFunction_Test_Internal($strAccountURL);
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

        $mockContact        = Mockery::mock("Canddi_Model_SecondOrder_Contact_Model")
            ->shouldReceive('setPPASuccess')
            ->once()
            ->andReturn($mockPPA_1)
            ->shouldReceive('bHasPPARun')
            ->once()
            ->with($mockPPA_1)
            ->andReturn(true)
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

        $processContact     = Canddi_Service_ProcessType_Contact::create($mockContact, $mockItems);

        $intResponse        = $processContact->processPPAs($mockProcessDeps);
        $this->assertEquals(2, $intResponse);
    }
    public function testProcessPPAs_DontSendTriggers_DontRunOnReprocess()
    {
        $strAccountURL      = "Test";

        $mockItems          = Mockery::mock("Canddi_Iterator_Cores");

        $mockParams         = Mockery::mock("Canddi_Model_Local_Process_Params_Action")
            ->shouldReceive('getRunOnReprocess')
            ->once()
            ->andReturn(false)
            ->mock();

        $arrDependencies_1  = [];
        $mockPF             = new Canddi_Service_ProcessFunction_Test_Internal($strAccountURL);
        $mockPPA_1          = Mockery::mock("Canddi_Model_Local_Process_Action_Abstract")
            ->shouldReceive('getParams')
            ->once()
            ->andReturn($mockParams)
            ->mock();

        $mockContact        = Mockery::mock("Canddi_Model_SecondOrder_Contact_Model")
            ->shouldReceive('setPPASuccess')
            ->once()
            ->andReturn($mockPPA_1)
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

        $processContact     = Canddi_Service_ProcessType_Contact::create($mockContact, $mockItems, false);

        $intResponse        = $processContact->processPPAs($mockProcessDeps);
        $this->assertEquals(2, $intResponse);
    }
    public function testProcessPPAs_DontSendTriggers_Works()
    {
        $strAccountURL      = "Test";

        $mockItems          = Mockery::mock("Canddi_Iterator_Cores");

        $mockParams         = Mockery::mock("Canddi_Model_Local_Process_Params_Action")
            ->shouldReceive('getRunOnReprocess')
            ->once()
            ->andReturn(true)
            ->mock();

        $mockOutputs        = Mockery::mock("Canddi_Iterator_Model_Child_Index")
            ->shouldReceive('rewind')
            ->once()
            ->shouldReceive('valid')
            ->once()
            ->andReturn(false)
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
        $mockPF             = new Canddi_Service_ProcessFunction_Test_Internal($strAccountURL);
        $mockPPA_1          = Mockery::mock("Canddi_Model_Local_Process_Action_Abstract")
            ->shouldReceive('getFunction')
            ->once()
            ->andReturn($mockPF)
            ->shouldReceive('getInputs')
            ->once()
            ->andReturn($mockInputs)
            ->shouldReceive('getParams')
            ->times(2)
            ->andReturn($mockParams)
            ->shouldReceive('getOutputs')
            ->once()
            ->andReturn($mockOutputs)
            ->shouldReceive('bCanSaveMultiple')
            ->once()
            ->andReturn(false)
            ->mock();

        $mockContact        = Mockery::mock("Canddi_Model_SecondOrder_Contact_Model")
            ->shouldReceive('setPPASuccess')
            ->once()
            ->andReturn($mockPPA_1)
            ->shouldReceive('bHasPPARun')
            ->once()
            ->with($mockPPA_1)
            ->andReturn(true)
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

        $processContact     = Canddi_Service_ProcessType_Contact::create($mockContact, $mockItems, false);

        $intResponse        = $processContact->processPPAs($mockProcessDeps);
        $this->assertEquals(2, $intResponse);
    }
}
