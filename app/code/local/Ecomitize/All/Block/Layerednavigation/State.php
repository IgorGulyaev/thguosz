<?php

class Ecomitize_All_Block_Layerednavigation_State extends Mage_Core_Block_Template
{
    public function getActiveFilters()
    {
        return array_filter(Mage::app()->getRequest()->getParams(), function($k) {
            return $k != 'id' && $k != 'dir' && $k != 'limit' && $k != '___SID';
        }, ARRAY_FILTER_USE_KEY);
    }

    public function getOptionData($id)
    {
        return Mage::getModel('aw_layerednavigation/filter_option')->load($id);
    }

    public function getClearUrl()
    {
        return  Mage::getUrl('*/*/*', array('_use_rewrite' => true, '_forced_secure' => true));
    }

    public function getFilteredUrl($parameterName)
    {
        $filterState = array_filter($this->getActiveFilters(), function($k)use($parameterName) {
            return $k != (string)$parameterName;
        }, ARRAY_FILTER_USE_KEY);

        $params['_use_rewrite'] = true;
        $params['_query']       = $filterState;

        return Mage::getUrl('*/*/*', $params);
    }

}