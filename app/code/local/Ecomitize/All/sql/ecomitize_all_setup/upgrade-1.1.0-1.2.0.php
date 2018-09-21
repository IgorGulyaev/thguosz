<?php

$this->startSetup();

$this->getConnection()->addColumn($this->getTable('banner/banner'), 'banner_background_color', array(
    'type'      => 'text',
    'comment'   => 'Banner background color'
));

$this->endSetup();