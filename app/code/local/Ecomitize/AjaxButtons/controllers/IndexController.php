<?php

require_once 'Mage' . DS . 'Wishlist' . DS . 'controllers' . DS . 'IndexController.php';

class Ecomitize_AjaxButtons_IndexController extends Mage_Wishlist_IndexController
{

    protected $isInWishlist;
    protected $message;

    public function preDispatch()
    {
        if ( $this->getRequest()->isXmlHttpRequest() ) {
            $grandparent = $this->getGrandParentClass($this);

            $grandparent::preDispatch();
        } else {
            parent::preDispatch();
        }
    }

    private function getGrandParentClass($object) {
        if (is_object($object)) {
            $className = get_class($object);
        }
        return get_parent_class(get_parent_class($className));
    }

    private function isLoggedIn()
    {
        if ( Mage::getSingleton("customer/session")->isLoggedIn() ) {
            return true;
        }

        $redirectLink = Mage::getUrl('customer/account/login');

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(['status' => 'login', 'redirectLink' => $redirectLink]));

        return false;
    }

    public function addAction()
    {
        if ( $this->getRequest()->isXmlHttpRequest() ) {
            if (!$this->isLoggedIn()) {
                return;
            }

            if (!$this->_validateFormKey()) {
                return $this->_redirect('*/*');
            }


            if ( $this->_addItemToWishList() ) {

                if ( $this->isInWishlist ) {
                    $redirectLink = Mage::getUrl('wishlist');

                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(['status' => 'wishlist', 'redirectLink' => $redirectLink]));

                    return;
                }

                $this->loadLayout();

                $wishlistLink = $this->getLayout()->createBlock('wishlist/links')->setBlockName('wishlist_link')->toHtml();

                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(['status' => 'success', 'wishlistLink' => $wishlistLink, 'message' => $this->message]));
            }
        } else {
            parent::addAction();
        }
    }

    public function removeAction()
    {
        if ( $this->getRequest()->isXmlHttpRequest() ) {
            $id = (int) $this->getRequest()->getParam('item');
            $item = Mage::getModel('wishlist/item')->load($id);
            $productName = $item->getProduct()->getName();

            if (!$item->getId()) {
                return $this->norouteAction();
            }
            $wishlist = $this->_getWishlist($item->getWishlistId());
            if (!$wishlist) {
                return $this->norouteAction();
            }
            try {
                $item->delete();
                $wishlist->save();
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('customer/session')->addError(
                    $this->__('An error occurred while deleting the item from wishlist: %s', $e->getMessage())
                );
            } catch (Exception $e) {
                Mage::getSingleton('customer/session')->addError(
                    $this->__('An error occurred while deleting the item from wishlist.')
                );
            }

            Mage::helper('wishlist')->calculate();

            $this->loadLayout();

            $wishlistLink = $this->getLayout()->createBlock('wishlist/links')->setBlockName('wishlist_link')->toHtml();

            $massage = $this->__('%1$s has been removed from your wishlist.', $productName);

            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(['status' => 'delete', 'wishlistLink' => $wishlistLink, 'message' => $massage]));

        } else {
            parent::removeAction();
        }

    }

    protected function _addItemToWishList()
    {
        if ( $this->getRequest()->isXmlHttpRequest() ) {
            $wishlist = parent::_getWishlist();
            if (!$wishlist) {
                return $this->norouteAction();
            }

            $session = Mage::getSingleton('customer/session');

            $productId = (int)$this->getRequest()->getParam('product');
            if (!$productId) {
                $this->_redirect('*/');
                return;
            }

            $product = Mage::getModel('catalog/product')->load($productId);
            if (!$product->getId() || !$product->isVisibleInCatalog()) {
                $session->addError($this->__('Cannot specify product.'));
                $this->_redirect('*/');
                return;
            }

            foreach ($wishlist->getItemCollection() as $item) {
                if ($item->representProduct($product)) {
                    $this->isInWishlist = true;
                    break;
                }
            }

            if ($this->isInWishlist) {
                return true;
            }

            try {
                $requestParams = $this->getRequest()->getParams();
                if ($session->getBeforeWishlistRequest()) {
                    $requestParams = $session->getBeforeWishlistRequest();
                    $session->unsBeforeWishlistRequest();
                }
                $buyRequest = new Varien_Object($requestParams);

                $result = $wishlist->addNewItem($product, $buyRequest);
                if (is_string($result)) {
                    Mage::throwException($result);
                }

                $wishlist->save();

                Mage::dispatchEvent(
                    'wishlist_add_product',
                    array(
                        'wishlist' => $wishlist,
                        'product' => $product,
                        'item' => $result
                    )
                );

                $referer = $session->getBeforeWishlistUrl();
                if ($referer) {
                    $session->setBeforeWishlistUrl(null);
                } else {
                    $referer = $this->_getRefererUrl();
                }

                /**
                 *  Set referer to avoid referring to the compare popup window
                 */
                $session->setAddActionReferer($referer);

                Mage::helper('wishlist')->calculate();

                $this->message = $this->__('%1$s has been added to your wishlist. Click <a href="%2$s">here</a> to continue shopping.',
                    $product->getName(), Mage::helper('core')->escapeUrl($referer));
            } catch (Mage_Core_Exception $e) {
                $session->addError($this->__('An error occurred while adding item to wishlist: %s', $e->getMessage()));
            } catch (Exception $e) {
                $session->addError($this->__('An error occurred while adding item to wishlist.'));
            }

            return true;
        } else {
            parent::_addItemToWishList();
        }
    }


}