<?php

require_once  'Mage' . DS . 'Catalog' . DS . 'controllers' . DS . 'Product' . DS . 'CompareController.php';

class Ecomitize_AjaxButtons_Product_CompareController extends Mage_Catalog_Product_CompareController
{
    public function addAction()
    {
        if ( $this->getRequest()->isXmlHttpRequest() ) {
            if (!$this->_validateFormKey()) {
                $this->_redirectReferer();
                return;
            }

            $response = array();
            $productId = (int)$this->getRequest()->getParam('product');
            $compared = false;

            if ($productId
                && (Mage::getSingleton('log/visitor')->getId() || Mage::getSingleton('customer/session')->isLoggedIn())
            ) {
                $product = Mage::getModel('catalog/product')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($productId);

                if ($product->getId()/* && !$product->isSuper()*/) {

                    $collection = Mage::getResourceModel('catalog/product_compare_item_collection')
                        ->useProductItem(true)
                        ->setStoreId(Mage::app()->getStore()->getId());

                    if (Mage::getSingleton('customer/session')->isLoggedIn()) {
                        $collection->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId());
                    }else {
                        $collection->setVisitorId(Mage::getSingleton('log/visitor')->getId());
                    }

                    foreach($collection as $comparingProduct) {
                        if ($comparingProduct->getId() == $productId) {
                            $compared = true;
                        }
                    }

                    Mage::getSingleton('catalog/product_compare_list')->addProduct($product);
                    Mage::dispatchEvent('catalog_product_compare_add_product', array('product' => $product));
                    $response['message'] = $this->__('The product %s has been added to comparison list.', Mage::helper('core')->escapeHtml($product->getName()));
                }

                Mage::helper('catalog/product_compare')->calculate();
            }

            if ( $compared ) {
                $response['redirect'] = Mage::getUrl('catalog/product_compare');
            } else {
                $this->loadLayout();
                $response['header'] = $this->getLayout()->createBlock('core/template')->setTemplate('catalog/product/compare/link.phtml')->toHtml();
            }

            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));

        } else {
            parent::addAction();
        }
    }


    public function removeAction()
    {
        if ( $this->getRequest()->isXmlHttpRequest() ) {
            $response = array();

            if ($productId = (int)$this->getRequest()->getParam('product')) {
                $product = Mage::getModel('catalog/product')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($productId);

                if ($product->getId()) {
                    /** @var $item Mage_Catalog_Model_Product_Compare_Item */
                    $item = Mage::getModel('catalog/product_compare_item');
                    $message = $this->__('The product %s has been removed from comparison list.', $product->getName());

                    if (Mage::getSingleton('customer/session')->isLoggedIn()) {
                        $item->addCustomerData(Mage::getSingleton('customer/session')->getCustomer());
                    } elseif ($this->_customerId) {
                        $item->addCustomerData(
                            Mage::getModel('customer/customer')->load($this->_customerId)
                        );
                    } else {
                        $item->addVisitorId(Mage::getSingleton('log/visitor')->getId());
                    }

                    $item->loadByProduct($product);

                    if ($item->getId()) {
                        $item->delete();

                        Mage::dispatchEvent('catalog_product_compare_remove_product', array('product' => $item));
                        Mage::helper('catalog/product_compare')->calculate();

                        $this->loadLayout();


                        $response['header'] = $this->getLayout()->createBlock('core/template')->setTemplate('catalog/product/compare/link.phtml')->toHtml();
                        $response['message'] = $message;

                        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
                    }
                }
            }
        } else {
            parent::removeAction();
        }
    }
}