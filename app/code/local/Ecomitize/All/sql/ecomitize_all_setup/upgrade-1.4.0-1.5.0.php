<?php

$this->startSetup();

$connection = $this->getConnection();

$connection->addColumn($this->getTable('banner/bannergroup'), 'random_count', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'comment'   => 'Random Count',
    'default' => 1,
    'nullable'  => false,
));

$this->endSetup();