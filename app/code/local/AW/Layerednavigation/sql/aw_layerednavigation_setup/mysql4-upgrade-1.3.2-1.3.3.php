<?php

$installer = $this;
$installer->startSetup();
$installer->run("
    ALTER TABLE {$installer->getTable('aw_layerednavigation/filter_option')} add column colorpicker char(10) not null;
");
$installer->endSetup();