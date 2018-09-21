<?php
/**
 * Created by PhpStorm.
 * User: destroy3r
 * Date: 17.11.16
 * Time: 16:29
 */ 
class Ecomitize_All_Block_Orderattr_Fields extends Amasty_Orderattr_Block_Fields
{
    public function getFormElementsCount()
    {
        $collection = Mage::getModel('eav/entity_attribute')->getCollection();
        $collection->addFieldToFilter('is_visible_on_front', 1);
        $collection->addFieldToFilter('entity_type_id', $this->_entityTypeId);

        if ($this->getStepCode() > 0) {
            $collection->addFieldToFilter('checkout_step', $this->getStepCode());
        }

        if ($this->getAttributeCode()) {
            $collection->addFieldToFilter('attribute_code', $this->getAttributeCode());
        }

        $collection->getSelect()->order('sorting_order');

        $attributes = $collection->load();

        return $attributes->getSize();
    }

}