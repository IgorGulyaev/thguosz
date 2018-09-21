<?php


class Ecomitize_All_ManufacturesController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->_forward('index', 'brand');
    }
}
