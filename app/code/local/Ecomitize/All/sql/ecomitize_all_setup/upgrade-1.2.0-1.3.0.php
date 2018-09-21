<?php
/**
 * New custom attribyte for category menu
 */

$this->startSetup();

$this->addAttribute(Mage_Catalog_Model_Category::ENTITY, 'menu_banner', array(
    'group'         => 'General Information',
    'input'         => 'select',
    'type'          => 'text',
    'label'         => 'Banner group code',
    'backend'       => '',
    'visible'       => true,
    'required'      => false,
    'wysiwyg_enabled' => false,
    'visible_on_front' => true,
    'is_html_allowed_on_front' => true,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'source'		=> 'ecomitize_all/attribute_menubanner',
));

$this->endSetup();