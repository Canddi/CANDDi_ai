<?php
class Canddi_StoreItems
    implements Canddi_Interface_Singleton,
               countable
{
    use Canddi_Traits_Singleton;

    const STORE_ITEMS_TYPE_NONE     = 0;
    const STORE_ITEMS_TYPE_MULTIPLE = 1;

    /**
     * List of storeItems
     **/
    private static $_arrStoreItems = [];
    /**
     * Stores a list of Exceptions
     *
     * @var array ( Exception )
     **/
    private $_arrExceptions = [];
    /**
     * Adds a storeItem to the list
     *
     * @return $this
     * @author Dan Dart
     **/
    public function add(Canddi_StoreItem_Abstract $storeItem)
    {
        $strInstance    = $storeItem->getInstanceName();

        self::$_arrStoreItems[$strInstance] = $storeItem;
        return $this;
    }
    /**
     * Returns the number of items to be processed
     *
     * @return integer
     **/
    public function count()
    {
        return count(self::$_arrStoreItems);
    }
    /**
     * Gets an array of Exceptions (if we've chosen not to throw in processAll)
     *
     * @return array (of Exceptions)
     *
     * @author Tim Langley
     **/
    public function getExceptions()
    {
        return $this->_arrExceptions;
    }
    /**
     * Traverses the storeItems and processes them all
     * then calls reset()
     *
     * @author Tim Langley
     **/
    public function processAll($bThrowExceptions = true)
    {
        $arrFinalItems              = [];
        while(!is_null($storeItem   = array_shift(self::$_arrStoreItems))) {
            if($storeItem->getFinal()) {
                $arrFinalItems[]    = $storeItem;
                continue;
            }
            try {
                $storeItem->process();
            } catch(Exception $e) {
                if($bThrowExceptions) {
                    throw new Exception($e);
                } else {
                    $this->_arrExceptions[] = $e;
                }
            }
        }

        //We've gotten rid of all the regular ones
        //Process the final ones now
        while(!is_null($storeItem   = array_shift($arrFinalItems))) {
            try {
                $storeItem->process();
            } catch(Exception $e) {
                if($bThrowExceptions) {
                    throw new Exception($e);
                } else {
                    $this->_arrExceptions[] = $e;
                }
            }
        }

        self::resetItems();
        return $this;
    }

    /**
     * Clears the storeItem list and hash
     *
     * @return void
     * @author Dan Dart
     **/
    public static function resetItems()
    {
        self::$_arrStoreItems           = [];
        self::reset();
    }
}
