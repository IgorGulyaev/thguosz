<?php

class Ecomitize_All_Model_Words
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'default', 'label'=>Mage::helper('ecomitize_all')->__('Default')),
            array('value'=>'wrap', 'label'=>Mage::helper('ecomitize_all')->__('Wrap')),
            array('value'=>'mega', 'label'=>Mage::helper('ecomitize_all')->__('Mega')),
        );
    }

}