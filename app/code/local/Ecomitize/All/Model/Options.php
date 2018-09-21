<?php

class Ecomitize_All_Model_Options
{
    public function toOptionArray()
    {
        return array(
            array('value'=>true, 'label'=>Mage::helper('ecomitize_all')->__('Enable')),
            array('value'=>false, 'label'=>Mage::helper('ecomitize_all')->__('Disable')),
        );
    }

}