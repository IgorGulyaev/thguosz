<?php

class Ecomitize_Popup_PopupController extends Mage_Core_Controller_Front_Action
{
    public function dontShowAction()
    {
        $params['unicName'] = '';
        $params['time'] = 0;

        $params = $this->getRequest()->getParams();
        Mage::getModel('core/cookie')->set('intervaldontshow'.$params['unicName'], 'disappear', (int)$params['time']);

        return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode( 'Cookies wrote!' ));
    }
}
