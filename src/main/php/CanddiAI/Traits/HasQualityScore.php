<?php
trait Canddi_Traits_HasQualityScore
{
    public static function getHasQualityScoreModelFields()
    {
        return [
            self::FIELD_QualityScore   => [
                "Type" => Canddi_Model_Abstract::UPDATE_TYPE_FIELD
            ]
        ];
    }
    public static function getHasQualityScoreJsonFields()
    {
        return [
            self::FIELD_QualityScore => [
                Canddi_Interface_ExportToArray::EXPORT_TYPE => Canddi_Interface_ExportToArray::EXPORTTYPE_VALUE,
                Canddi_Interface_ExportToArray::EXPORT_FUNCTION =>"getQualityScore"
            ]
        ];
    }
    public function getQualityScore()
    {
        return $this->_getField(self::FIELD_QualityScore, Canddi_Helper_QualityScore::DEFAULT_VALUE);
    }
    public function setQualityScore($intQualityScore = Canddi_Helper_QualityScore::DEFAULT_VALUE)
    {
        $intCurrentQualityScore = $this->getQualityScore();
        if ($intQualityScore >= $intCurrentQualityScore) {
            $this->_setField(self::FIELD_QualityScore, $intQualityScore);
        }
    }
}
