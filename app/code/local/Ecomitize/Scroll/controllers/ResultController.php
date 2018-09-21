<?php
/**
 * Created by PhpStorm.
 * User: destroy3r
 * Date: 23.03.16
 * Time: 14:09
 */
require_once 'Mage/CatalogSearch/controllers/ResultController.php';


class Ecomitize_Scroll_ResultController extends Mage_CatalogSearch_ResultController
{

    public function indexAction()
    {
        $params = $this->getRequest()->getParams();
        if ( $this->getRequest()->isXmlHttpRequest() &&
            ( isset($params['scroll']) || isset($params['sort']) || isset($params['list-view']) ) &&
            !isset($params['aw_layerednavigation']) )
        {
            $query = Mage::helper('catalogsearch')->getQuery();
            /* @var $query Mage_CatalogSearch_Model_Query */

            $query->setStoreId(Mage::app()->getStore()->getId());

            if ($query->getQueryText() != '') {
                if (Mage::helper('catalogsearch')->isMinQueryLength()) {
                    $query->setId(0)
                        ->setIsActive(1)
                        ->setIsProcessed(1);
                } else {
                    if ($query->getId()) {
                        $query->setPopularity($query->getPopularity() + 1);
                    } else {
                        $query->setPopularity(1);
                    }

                    if ($query->getRedirect()) {
                        $query->save();
                        $this->getResponse()->setRedirect($query->getRedirect());
                        return;
                    } else {
                        $query->prepare();
                    }
                }

                Mage::helper('catalogsearch')->checkNotes();

                if (!Mage::helper('catalogsearch')->isMinQueryLength()) {
                    $query->save();
                }

                $this->loadLayout();

                $productList = $this->getLayout()->getBlock('search.result')->getChild('search_result_list');

                $response['product_list'] = $productList->toHtml();
                $response['toolbar'] = $productList->getChild('toolbar')->toHtml();

                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));

                return;
            } else {
                $this->_redirectReferer();
            }
        } else {
            parent::indexAction();
        }
    }
}