<?php

$this->startSetup();

$connection = $this->getConnection();

$connection->addColumn($this->getTable('banner/bannergroup'), 'masterslider', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'comment'   => 'Masterslider'
));

$this->endSetup();