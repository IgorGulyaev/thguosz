<?php

$this->startSetup();

$connection = $this->getConnection();

$connection->addColumn($this->getTable('banner/banner'), 'active_link_color', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment'   => 'Active link color'
));

$connection->addColumn($this->getTable('banner/banner'), 'button_text', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment'   => 'Button Text'
));

$connection->addColumn($this->getTable('banner/bannergroup'), 'auto_scroll', array(
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'comment'   => 'Auto scroll'
));

$connection->addColumn($this->getTable('banner/bannergroup'), 'auto_scroll_timeout', array(
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment'   => 'Auto scroll timeout'
));
$connection->addColumn($this->getTable('banner/bannergroup'), 'active_item', array(
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'comment'   => 'Banner id'
));

$connection->addColumn($this->getTable('banner/bannergroup'), 'random', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'comment'   => 'Random'
));

$connection->addColumn($this->getTable('banner/bannergroup'), 'slider', array(
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'comment'   => 'Slider'
));

$this->endSetup();