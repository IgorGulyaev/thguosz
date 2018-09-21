<?php

class Ecomitize_All_Block_Brand_Brand
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{
    protected $brandCollection;

    public function __construct()
    {
        $this->brandCollection = $this->getBrandCollection();
        parent::__construct();
    }

    public function getBrandCollection()
    {
        $storeId  = Mage::app()->getStore()->getId();

        $collection = Mage::getModel('aw_layerednavigation/filter_option')
            ->getCollection();

        /** @var Mage_Core_Model_Resource $resource */
        $resource = Mage::getSingleton('core/resource');

        $select = $collection->getSelect();
        $select->join(
            array('filter' => $resource->getTableName('aw_layerednavigation/filter')),
            'main_table.filter_id = filter.entity_id',
            array()
        )->join(
            array('filter_val' => $resource->getTableName('aw_layerednavigation/filter_option_eav')),
            'main_table.option_id = filter_val.option_id',
            array('name', 'value')
        )->where('filter.code = ?', 'brands')
            ->where('filter_val.store_id = ?', $storeId);

//        echo $select->__toString();

        return $collection;
    }
}
