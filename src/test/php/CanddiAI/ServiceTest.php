<?php

/**
 * @category
 * @package
 * @copyright  2011-06-05 (c) 2011 Campaign and Digital Intelligence (http://canddi.com)
 * @license
 * @author     Oli Wood
 * */

use Canddi\Module\CRM\Service as NS_Service_CRM;

class Canddi_ServiceTest extends Canddi_TestCase
{
    public function testGetDependencyHandler()
    {
        $strAccountURL = "canddi";
        $mockIttPPAs = Mockery::mock('Canddi_Iterator_Interface');
        $service = Canddi_Service::getInstance();
        $dh = $service->getDependencyHandler($strAccountURL, $mockIttPPAs);
        $this->assertEquals('Canddi_Iterator_Process_Handler', get_class($dh));
    }
    public function testGetProcess()
    {
        $service        = Canddi_Service::getInstance();
        $mockCoreItems  = Mockery::mock("Canddi_Iterator_Cores");

        $mockContact= Mockery::mock("Canddi_Model_SecondOrder_Contact_Model");
        $return     = $service->getProcess($mockContact, $mockCoreItems);
        $this->assertTrue(
            $return instanceof Canddi_Service_ProcessType_Contact
        );

        $mockSessionGoal = Mockery::mock("Canddi_Model_FirstOrder_SessionGoal_Abstract");
        $return     = $service->getProcess($mockSessionGoal, $mockCoreItems);
        $this->assertTrue(
            $return instanceof Canddi_Service_ProcessType_SessionGoal
        );

        $mockSession= Mockery::mock("Canddi_Model_FirstOrder_Session_Abstract");
        $return     = $service->getProcess($mockSession, $mockCoreItems);
        $this->assertTrue(
            $return instanceof Canddi_Service_ProcessType_Session
        );

        $mockPPASave= Mockery::mock("Canddi_Interface_PPABaseModel");
        try {
            $service->getProcess($mockPPASave, $mockCoreItems);
            throw new Exception("TEST FAIL");
        } catch(Canddi_Exception_Fatal_UnknownType $e) {

        }
    }
}
