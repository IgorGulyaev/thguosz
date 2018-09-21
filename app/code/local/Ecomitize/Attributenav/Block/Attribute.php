<?php

class Ecomitize_Attributenav_Block_Attribute
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{
    protected $attributeCollection;
    protected $attributeCode;

    public function __construct()
    {
        parent::__construct();
    }

    public function getCollection()
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
        )->joinLeft(
            array('filter_val_def' => $resource->getTableName('aw_layerednavigation/filter_option_eav')),
            'main_table.option_id = filter_val_def.option_id AND filter_val_def.name = \'title\' AND filter_val_def.store_id = 0',
            array()
        )->joinLeft(
            array('filter_val' => $resource->getTableName('aw_layerednavigation/filter_option_eav')),
            'main_table.option_id = filter_val.option_id AND filter_val.name = \'title\' AND filter_val.store_id = ' . $storeId,
            array(
                'name'     => new Zend_Db_Expr('IF(filter_val.name, filter_val.name, filter_val_def.name)'),
                'value'    => new Zend_Db_Expr('IF(filter_val.value, filter_val.value, filter_val_def.value)'),
                'store_id' => new Zend_Db_Expr('IF(filter_val.store_id, filter_val.store_id, filter_val_def.store_id)')
            )
        )->where('filter.code = ?', $this->attributeCode);

        return $collection;
    }

    public function setAttributeCode($attributeCode=null) {
        $this->attributeCode = $attributeCode;

        return $this;
    }
}
