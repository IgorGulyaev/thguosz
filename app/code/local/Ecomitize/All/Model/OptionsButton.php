<?php

class Ecomitize_All_Model_OptionsButton
{
    public function toOptionArray()
    {
        return array(
            array('value'=>true, 'label'=>Mage::helper('ecomitize_all')->__('Infinite')),
            array('value'=>false, 'label'=>Mage::helper('ecomitize_all')->__('Button')),
        );
    }

}