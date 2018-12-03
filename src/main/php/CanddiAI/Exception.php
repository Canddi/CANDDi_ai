<?php
/**
 * @category
 * @package
 * @copyright  2011-05-19 (c) 2011-12 Campaign and Digital Intelligence
 * @license
 * @author     Tim Langley
 **/

namespace CanddiAI;

class CanddiAI_Exception extends Exception
{
    const HTTP_500 = 500;

    public function __construct($strMessage, $intCode = CanddiAI_Exception::HTTP_500)
    {
        parent::__construct($strMessage, $intCode);
    }
}