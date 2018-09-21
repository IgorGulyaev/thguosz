<?php

class Ecomitize_Attributenav_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $params = $this->getRequest()->getParams();

        if ( ($this->getRequest()->isXmlHttpRequest() &&  isset($params['scroll'])) && !isset($params['aw_layerednavigation'])  ) {

            $this->loadLayout();

            $productList = $this->getLayout()->getBlock('product_list');

            $response['product_list'] = $productList->toHtml();
            $response['toolbar'] = $productList->getChild('toolbar')->toHtml();

            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));

        } else {
            $this->loadLayout();
            $this->renderLayout();
        }
    }
}