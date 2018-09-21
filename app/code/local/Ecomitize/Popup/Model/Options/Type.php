<?php
class Ecomitize_Popup_Model_Options_Type
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'banner', 'label'=>Mage::helper('ecomitize_popup')->__('Banner')),
//            array('value'=>'form', 'label'=>Mage::helper('ecomitize_popup')->__('form')),
            array('value'=>'iframe', 'label'=>Mage::helper('ecomitize_popup')->__('Iframe')),
            array('value'=>'video', 'label'=>Mage::helper('ecomitize_popup')->__('Video')),
            array('value'=>'subscribe', 'label'=>Mage::helper('ecomitize_popup')->__('Subscribe')),
            array('value'=>'coupon', 'label'=>Mage::helper('ecomitize_popup')->__('Coupon')),
        );
    }
}