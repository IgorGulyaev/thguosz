<?php
class Ecomitize_Popup_Model_Options_Speed
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'0.4', 'label'=>Mage::helper('ecomitize_popup')->__('fast')),
            array('value'=>'1.0', 'label'=>Mage::helper('ecomitize_popup')->__('normal')),
            array('value'=>'1.6', 'label'=>Mage::helper('ecomitize_popup')->__('slow')),
        );
    }
}