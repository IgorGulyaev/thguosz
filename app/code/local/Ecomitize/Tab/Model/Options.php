<?php
class Ecomitize_Tab_Model_Options {

    public function toOptionArray() {
        return [
            ['value' => 'featured', 'label' => Mage::helper('ecomitize_all')->__('Featured')],
            ['value' => 'viewed', 'label' => Mage::helper('ecomitize_all')->__('Viewed')],
            ['value' => 'sale', 'label' => Mage::helper('ecomitize_all')->__('Special Offers')],
            ['value' => 'news', 'label' => Mage::helper('ecomitize_all')->__('News')],
        ];
    }
}