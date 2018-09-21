<?php

class Ecomitize_Tab_Block_Adminhtml_System_Config_Field_Tab
    extends Mage_Core_Block_Html_Select
{
    const SPACE = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    public function _toHtml()
    {
        $options = Mage::getModel('ecomitize_tab/options')->toOptionArray();

        foreach ($options as $option) {
            $option['label'] = str_replace("'", "", $option['label']);
            $this->addOption($option['value'], $option['label']);
        }
        return parent::_toHtml();
    }

    public function setInputName($value)
    {
        return $this->setName($value);
    }
}