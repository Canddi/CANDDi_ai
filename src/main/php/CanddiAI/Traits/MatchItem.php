<?php

use CanddiAI\Account\Widget\Core\ContactTag as NS_Widget_Core_ContactTag;

trait Canddi_Traits_MatchItem
{
    protected function _transform(
        Canddi_Helper_Formula $formula = null,
        \Canddi_Model_Local_Process_Params_Action $modelParams
    ) {
        if (is_null($formula)) {
            throw new Canddi_Exception_Ignore_ItemDoesNotExist('Email, Company or IP');
        }

        //By this time formula will be real and populated
        $ittMatches             = Canddi_Gateway::getInstance()
            ->getMatch($this->_getAccountURL())
            ->getAllByFormula($formula);

        $arrData            = [];
        foreach ($ittMatches as $modelMatch) {
            //We're going to create a ContactTagWidget
            // @TODO - this should be refactored to a more generic way of working
            $strTag         = $modelMatch->getCFType();
            $intValue       = 1;
            $strFunction    =NS_Widget_Core_ContactTag::VALUE_FUNCTION_INC;
            $arrWidget      = [
                NS_Widget_Core_ContactTag::OUTPUT_FUNCTION    => $strFunction,
                NS_Widget_Core_ContactTag::OUTPUT_NAME        => $strTag,
                NS_Widget_Core_ContactTag::OUTPUT_VALUE       => $intValue
            ];
            $arrData[]      = $arrWidget;
        }

        $coreWidget     = Canddi_Core_Widget::create(
            NS_Widget_Core_ContactTag::ID,
            NS_Widget_Core_ContactTag::ID,
            $arrData
        );

        $result             = new Canddi_Iterator_Process_Result();
        $result->addCore(
            $coreWidget,
            $modelParams->bIsDelete(),
            $modelParams->bIsManual()
        );
        return $result;
    }
}
