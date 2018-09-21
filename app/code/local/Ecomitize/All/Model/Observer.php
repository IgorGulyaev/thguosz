<?php

class Ecomitize_All_Model_Observer {

    public function renderBefore()
    {
        $topSearch = Mage::app()->getLayout()->getBlock('top.search');
        if ($topSearch) {
            $topSearch->setCategory(Mage::app()->getRequest()->getParam('category'));
        }
    }

    /**
     * Adds layerednavigation id to awln_option_id attribute
     */
    public function synchronize()
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
    }

    /**
     * Overrides super_product_attributes_prepare_save from Amasty_Conf module
     *
     * @param $observer
     */
    public function onSuperProductAttributesPrepareSave($observer){
        $configurableJsonData = $observer->getRequest()->getPost('configurable_attributes_data');
        $configurable_attributes_data = '';

        if (!empty($configurableJsonData)) {
            $configurable_attributes_data = Mage::helper('core')->jsonDecode($configurableJsonData);
        }

        if (is_array($configurable_attributes_data)){
            foreach($configurable_attributes_data as $attribute){

                if ($attribute['id'] !== NULL){
                    $confAttr = Mage::getModel('amconf/product_attribute')->load($attribute['id'], 'product_super_attribute_id');

                    if (!$confAttr->getId())
                    {
                        $confAttr->setProductSuperAttributeId($attribute['id']);
                    }
                    $use_image_from_product  = isset($attribute['use_image_from_product']) ? intval($attribute['use_image_from_product']) : 0;

                    $confAttr->setUseImageFromProduct($use_image_from_product);
                    $confAttr->save();
                }
            }
        }
    }
}