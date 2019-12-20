<?php

/**
 * @author Luke Roberts
 */

namespace CanddiAi\Lookup;

class FunctionalTest_NormalizeName
    extends \CanddiAi\Functional_TestCase
{
    private $_strBaseUri = '';
    private $_strAccessToken = '';

    public function testNormalizeName()
    {
        $strName = 'Logan White';

        $instance = NormalizeName::getInstance($this->_strBaseUri, $this->_strAccessToken);

        $response = $instance->normalizeName($strName);

        error_log(print_r($this->_getProtAttr($response, '_arrResponse'), true));
    }
}
