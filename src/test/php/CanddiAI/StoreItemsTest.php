<?php
class Canddi_StoreItemsTest extends Canddi_TestCase
{
    public function setUp()
    {
        parent::setUp();
        Canddi_StoreItems::resetItems();
    }

    public function testGetInstance()
    {
        $objStoreItems  = Canddi_StoreItems::getInstance();
        $this->assertEquals(
            'Canddi_StoreItems', get_class($objStoreItems)
        );
        $this->assertEquals(0, count($objStoreItems));

        $objStoreItems->processAll(false);
        $arrExceptions          = $objStoreItems->getExceptions();
        $strExceptions          = "";
        foreach($arrExceptions as $objException) {
            $strExceptions      .= sprintf("%s - %s - %s".chr(10),
                $objException->getMessage(),
                $objException->getFile(),
                $objException->getLine()
            );
        }
        $this->assertEquals("", $strExceptions);
    }

    public function testInject()
    {
        $mockItems = \Mockery::mock('Canddi_StoreItems');
        Canddi_StoreItems::inject($mockItems);
        $this->assertEquals($mockItems, Canddi_StoreItems::getInstance());
        //We don't need to run process - but we do need to do this s.t not to break assert later
        Canddi_StoreItems::resetItems();
    }
    public function testAddAndProcess_ReturnExceptions()
    {
        $mockException          = new Exception("oops");
        $mockStoreItemOk        = Mockery::mock('Canddi_StoreItem_Abstract')
            ->shouldReceive('getInstanceName')
            ->once()
            ->andReturn(rand())
            ->shouldReceive('process')
            ->once()
            ->shouldReceive('getFinal')
            ->once()
            ->andReturn(false)
            ->mock();
        $mockStoreItemException = Mockery::mock('Canddi_StoreItem_Abstract')
            ->shouldReceive('getInstanceName')
            ->once()
            ->andReturn(rand())
            ->shouldReceive('process')
            ->once()
            ->andThrow($mockException)
            ->shouldReceive('getFinal')
            ->once()
            ->andReturn(false)
            ->mock();

        $storeItems             = Canddi_StoreItems::getInstance();
        $storeItems->add($mockStoreItemOk);
        $storeItems->add($mockStoreItemException);

        $this->assertEquals(2,  $storeItems->count());
        $storeItems->processAll(false);
        $arrResponse            = $storeItems->getExceptions();
        $this->assertEquals([$mockException], $arrResponse);
        $this->assertEquals(0,  $storeItems->count());
        //We don't need to run process - but we do need to do this s.t not to break assert later
        Canddi_StoreItems::resetItems();
    }
    public function testAddAndProcess_ThrowsExceptions()
    {
        $mockException          = new Exception("oops");
        $mockStoreItemException = Mockery::mock('Canddi_StoreItem_Abstract')
            ->shouldReceive('getInstanceName')
            ->once()
            ->andReturn(rand())
            ->shouldReceive('process')
            ->once()
            ->andThrow($mockException)
            ->shouldReceive('getFinal')
            ->once()
            ->andReturn(false)
            ->mock();

        $storeItems = Canddi_StoreItems::getInstance();
        $storeItems->add($mockStoreItemException);

        try {
            $storeItems->processAll();
            //This is stupid but forces test to fail
            //since we cant't catch generic exception
            $this->assertFalse(true);
        } catch(Exception $e) {}
        //We don't need to run process - but we do need to do this s.t not to break assert later
        Canddi_StoreItems::resetItems();
    }
    public function testAddAndProcess_CheckSingletonsWork()
    {
        $mockStoreItemOk        = Mockery::mock('Canddi_StoreItem_Abstract')
            ->shouldReceive('getInstanceName')
            ->once()
            ->andReturn(rand())
            ->shouldReceive('process')
            ->once()
            ->shouldReceive('getFinal')
            ->once()
            ->andReturn(false)
            ->mock();

        $strName                = "testSingleton";
        $mockStoreItemSingle    = Mockery::mock('Canddi_StoreItem_Abstract')
            ->shouldReceive('getInstanceName')
            ->once()
            ->andReturn($strName)
            ->mock();

        $storeItems             = Canddi_StoreItems::getInstance();
        $storeItems->add($mockStoreItemOk);
        $storeItems->add($mockStoreItemSingle);
        $this->assertEquals(2,  $storeItems->count());

        //Add the same Singleton again
        $mockStoreItemSingle2   = Mockery::mock('Canddi_StoreItem_Abstract')
            ->shouldReceive('process')
            ->once()
            ->shouldReceive('getInstanceName')
            ->once()
            ->andReturn($strName)
            ->shouldReceive('getFinal')
            ->once()
            ->andReturn(false)
            ->mock();
        $storeItems->add($mockStoreItemSingle2);
        $this->assertEquals(2,  $storeItems->count());

        $storeItems->processAll(false);

        $this->assertEquals(0,  $storeItems->count());
        //We don't need to run process - but we do need to do this s.t not to break assert later
        Canddi_StoreItems::resetItems();
    }
    public function testAddAndProcess_CheckFinalWorks()
    {
        $mockStoreItemOk        = Mockery::mock('Canddi_StoreItem_Abstract')
            ->shouldReceive('getInstanceName')
            ->once()
            ->andReturn(rand())
            ->shouldReceive('process')
            ->once()
            ->shouldReceive('getFinal')
            ->once()
            ->andReturn(true)
            ->mock();

        $strName                = "testSingleton";
        $mockStoreItemSingle    = Mockery::mock('Canddi_StoreItem_Abstract')
            ->shouldReceive('process')
            ->once()
            ->shouldReceive('getInstanceName')
            ->once()
            ->andReturn($strName)
            ->shouldReceive('getFinal')
            ->once()
            ->andReturn(false)
            ->mock();

        $storeItems             = Canddi_StoreItems::getInstance();
        $storeItems->add($mockStoreItemOk);
        $storeItems->add($mockStoreItemSingle);
        $this->assertEquals(2,  $storeItems->count());

        $storeItems->processAll(false);

        $this->assertEquals(0,  $storeItems->count());
        //We don't need to run process - but we do need to do this s.t not to break assert later
        Canddi_StoreItems::resetItems();
    }
}
