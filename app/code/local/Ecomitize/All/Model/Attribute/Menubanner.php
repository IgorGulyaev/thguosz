<?php

class Ecomitize_All_Model_Attribute_Menubanner extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $model = Mage::getModel("banner/bannergroup")
                ->getCollection()
                ->load();

            $i=0;
            foreach ($model as $banner){
                $option[$i]['label'] = $banner->getGroupCode();
                $option[$i]['value'] = $banner->getGroupCode();
                $i++;
            }
            $option[$i]['label'] = Mage::helper('ecomitize_all')->__('Disable');
            $option[$i]['value'] = false;
            $this->_options = $option;
        }
        return $this->_options;
    }

    public function toOptionArray()
    {
        return $this->getAllOptions();
    }

}