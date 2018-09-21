<?php

require_once 'Mage/Catalog/controllers/CategoryController.php';


class Ecomitize_Scroll_CategoryController extends Mage_Catalog_CategoryController {

    public function viewAction()
    {
        $params = $this->getRequest()->getParams();

        if ( $this->getRequest()->isXmlHttpRequest() &&
            ( isset($params['scroll']) || isset($params['sort']) || isset($params['list-view']) ) &&
              !isset($params['aw_layerednavigation']) )
        {

            if ($category = $this->_initCatagory()) {
                $design = Mage::getSingleton('catalog/design');
                $settings = $design->getDesignSettings($category);

                if ($settings->getCustomDesign()) {
                    $design->applyCustomDesign($settings->getCustomDesign());
                }

                Mage::getSingleton('catalog/session')->setLastViewedCategoryId($category->getId());

                $update = $this->getLayout()->getUpdate();
                $update->addHandle('default');

                if (!$category->hasChildren()) {
                    $update->addHandle('catalog_category_layered_nochildren');
                }

                $this->addActionLayoutHandles();
                $update->addHandle($category->getLayoutUpdateHandle());
                $update->addHandle('CATEGORY_' . $category->getId());
                $this->loadLayoutUpdates();

                if ($layoutUpdates = $settings->getLayoutUpdates()) {
                    if (is_array($layoutUpdates)) {
                        foreach ($layoutUpdates as $layoutUpdate) {
                            $update->addUpdate($layoutUpdate);
                        }
                    }
                }

                $this->generateLayoutXml()->generateLayoutBlocks();

                if ($settings->getPageLayout()) {
                    $this->getLayout()->helper('page/layout')->applyTemplate($settings->getPageLayout());
                }

                $productList = $this->getLayout()->getBlock('product_list');

                $response['product_list'] = $productList->toHtml();
                $response['toolbar'] = $productList->getToolbarBlock()->toHtml();

                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));

                return;
            } elseif (!$this->getResponse()->isRedirect()) {
                $this->_forward('noRoute');
            }
        } else {
            parent::viewAction();
        }
    }
}