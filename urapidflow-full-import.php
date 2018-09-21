<?php
 
// initialize Magento environment
include_once "app/Mage.php";
Mage::app('admin')->setCurrentStore(0);
 
$helper = Mage::helper('urapidflow');

// Import Visible Products:
$helper->run(1);

// Import Descriptions:
$helper->run(2);

// Import Grid Associations:
$helper->run(3);

// Import Image Gallery:
$helper->run(4);



 