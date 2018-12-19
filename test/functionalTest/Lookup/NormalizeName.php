<?php

/**
 * @author Luke Roberts
 */

namespace CanddiAi\Lookup;

class FunctionalTest_NormalizeName
    extends \CanddiAi\Functional_TestCase
{
    private $_strApiKey = '5RPIBLH2t61mJb6BRUjGa4Rm5TB56Xp22YAFaB8o';
    private $_strBaseUri = 'https://ip.canddi.ai';

    public function testNormalizeName()
    {
        $strName = 'Logan White';

        $instance = NormalizeName::getInstance($this->_strBaseUri, $this->_strApiKey);

        $response = $instance->normalizeName($strName);

        error_log(print_r($this->_getProtAttr($response, '_arrResponse'), true));
    }
}
