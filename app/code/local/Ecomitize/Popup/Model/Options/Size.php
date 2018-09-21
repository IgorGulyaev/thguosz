<?php
class Ecomitize_Popup_Model_Options_Size
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'sm', 'label'=>Mage::helper('ecomitize_popup')->__('small')),
            array('value'=>'md', 'label'=>Mage::helper('ecomitize_popup')->__('medium')),
            array('value'=>'lg', 'label'=>Mage::helper('ecomitize_popup')->__('large')),
        );
    }
}