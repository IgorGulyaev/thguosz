<?php

class Ecomitize_All_Model_Position
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'default', 'label'=>Mage::helper('ecomitize_all')->__('Default')),
            array('value'=>'fixed', 'label'=>Mage::helper('ecomitize_all')->__('Fixed')),
        );
    }

}