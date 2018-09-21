<?php

class Ecomitize_Popup_Model_Options_Enable
{
    public function toOptionArray()
    {
        return array(
            array('value'=>true, 'label'=>Mage::helper('ecomitize_popup')->__('Enable')),
            array('value'=>false, 'label'=>Mage::helper('ecomitize_popup')->__('Disable')),
        );
    }

}