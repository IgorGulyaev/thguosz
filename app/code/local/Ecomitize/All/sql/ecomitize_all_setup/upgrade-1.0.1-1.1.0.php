<?php
/**
 * New custom attribyte for category menu
 */

$this->startSetup();
$this->addAttribute(Mage_Catalog_Model_Category::ENTITY, 'menu_category_image_link', array(
    'group'         => 'General Information',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Link for menu category image',
    'backend'       => '',
    'visible'       => true,
    'required'      => false,
    'visible_on_front' => true,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
))->addAttribute(Mage_Catalog_Model_Category::ENTITY, 'menu_category_image', array(
    'group'         => 'General Information',
    'input'         => 'image',
    'type'          => 'varchar',
    'label'         => 'Image menu for category',
    'backend'       => 'ecomitize_all/category_attribute_backend_image',
    'visible'       => true,
    'required'      => false,
    'wysiwyg_enabled' => false,
    'visible_on_front' => true,
    'is_html_allowed_on_front' => true,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
))->addAttribute(Mage_Catalog_Model_Category::ENTITY, 'menu_category_image_alt', array(
    'group'         => 'General Information',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Alt for menu category image',
    'backend'       => '',
    'visible'       => true,
    'required'      => false,
    'wysiwyg_enabled' => false,
    'visible_on_front' => true,
    'is_html_allowed_on_front' => true,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
));

$this->endSetup();