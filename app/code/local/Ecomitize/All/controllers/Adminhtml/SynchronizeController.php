<?php

class Ecomitize_All_Adminhtml_SynchronizeController extends Mage_Adminhtml_Controller_action
{
    public function indexAction()
    {
        $collection = Mage::getModel('aw_layerednavigation/filter_option')
            ->getCollection()->addFieldToFilter('additional_data', array('like' => '%category_id%' ));

        foreach ( $collection as $option ) {
            $additionalData = $option->getAdditionalData();

            if ( $additionalData ) {
                if ( isset($additionalData['category_id']) ) {
                    $category = Mage::getModel('catalog/category')->load($additionalData['category_id']);

                    $category->setData('awln_option_id', $option->getData('option_id'));
                    $category->setStoreId(0);

                    $category->save();
                }
            }
        }

        Mage::getSingleton('adminhtml/session')->addSuccess("Synchronize success");
        $this->_redirectReferer();
    }
}