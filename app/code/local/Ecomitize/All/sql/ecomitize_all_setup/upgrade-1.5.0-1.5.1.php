<?php
/**
 * Product attribute for sticker on front end
 */

$this->startSetup();
$this->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'sticker', array(
    'group'         => 'General',
    'attribute_set' => 'Default',
    'input'         => 'select',
    'type'          => 'int',
    'label'         => 'Sticker',
    'default'       => 'default',
    'visible'       => true,
    'required'      => false,
    'visible_on_front' => true,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'option'        =>
        array (
            'values' =>
                array (
                    0 => 'No',
                    1 => 'New',
                    2 => 'Sale'
                ),
        ),
));
$this->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'sticker', 'is_filterable_in_search', 1);
$this->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'sticker', 'is_filterable', 1);
$this->endSetup();