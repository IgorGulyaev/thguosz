<?php
class Ecomitize_Popup_Model_Options_Appearanceinterval
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'0', 'label'=>Mage::helper('ecomitize_popup')->__('Disable')),
            array('value'=>'300', 'label'=>Mage::helper('ecomitize_popup')->__('5 min')),
            array('value'=>'900', 'label'=>Mage::helper('ecomitize_popup')->__('15 min')),
            array('value'=>'1800', 'label'=>Mage::helper('ecomitize_popup')->__('30 min')),
            array('value'=>'3600', 'label'=>Mage::helper('ecomitize_popup')->__('60  min')),
            array('value'=>'10800', 'label'=>Mage::helper('ecomitize_popup')->__('3 hours')),
            array('value'=>'86400', 'label'=>Mage::helper('ecomitize_popup')->__('1 day')),
            array('value'=>'259200', 'label'=>Mage::helper('ecomitize_popup')->__('3 days')),
        );
    }
}