<?php
class Ecomitize_Popup_Model_Options_Videofrom
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'youtube', 'label'=>Mage::helper('ecomitize_popup')->__('youtube')),
            array('value'=>'vimeo', 'label'=>Mage::helper('ecomitize_popup')->__('vimeo')),
        );
    }
}