<?php
 
// initialize Magento environment
include_once "app/Mage.php";
Mage::app('admin')->setCurrentStore(0);
 
$helper = Mage::helper('urapidflow');

// Import Updates:
$helper->run(5);







 