<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Prutyan
 * Date: 12/21/2015
 * Time: 4:27 PM
 */

class Ecomitize_All_Helper_data extends Mage_Core_Helper_Abstract {

    protected static $wishListIds = array();

    protected static $comparingProductsIds = array();

    public function getManufacturers(){

        $options = array();
        $attribute = Mage::getSingleton('eav/config')
            ->getAttribute(Mage_Catalog_Model_Product::ENTITY, 'manufacturer');

        if ($attribute->usesSource()) {
            $options = $attribute->getSource()->getAllOptions(false);
        }

        return $options;
    }

    public function getBrands(){

        $options = array();
        $attribute = Mage::getSingleton('eav/config')
            ->getAttribute(Mage_Catalog_Model_Product::ENTITY, 'brand');

        if ($attribute->usesSource()) {
            $options = $attribute->getSource()->getAllOptions(false);
        }
        return $options;
    }

    public function getConfigurableOptionsPriceRange($_product){

        if($_product->getTypeId() == 'simple'){
            return $_product->getFinalPrice();
        }

        if($_product->getTypeId() == 'configurable') {

            $block = Mage::app()->getLayout()->createBlock('catalog/product_view_type_configurable');
            $block->setProduct($_product);
            $_products = $block->getAllowProducts();
            $config = json_decode($block->getJsonConfig(), true);

            $basePrice = $_product->getSpecialPrice();
            if (is_null($basePrice)) {
                $basePrice = $_product->getFinalPrice();
            }

            foreach ($_products as $_allowProduct) {
                $option_price = 0;
                foreach ($config['attributes'] as $aId => $aValues) {
                    foreach ($aValues['options'] as $key => $value) {
                        if ($value['label'] === $_allowProduct->getAttributeText($aValues['code'])) {
                            $option_price += $value['price'];
                        }
                    }
                }
                $priceRange[] = $option_price + $basePrice;
            }

            return min($priceRange);
        }
    }

    public function getSavedPercentage ($firstPrice, $secondPrice)
    {
        if($firstPrice == $secondPrice){
            return '0%';
        }

        if($firstPrice > $secondPrice){
            $_actualPrice = $firstPrice;
            $_specialPrice = $secondPrice;
        }else{
            $_actualPrice = $secondPrice;
            $_specialPrice = $firstPrice;
        }
        $percentage = round((($_actualPrice - $_specialPrice) / $_actualPrice)*100 );

        return $percentage.'%';
    }


    public function getSticker($productId,$attributeCode = 'sticker')
    {
        return Mage::getModel('catalog/product')
            ->load($productId)
            ->getAttributeText($attributeCode);
    }

    public function isInWishList($product) {
        if ( empty(self::$wishListIds) ) {
            if ( Mage::getSingleton('customer/session')->isLoggedIn() ) {
                $customer = Mage::getSingleton('customer/session')->getCustomer();
                $wishlist = Mage::getModel('wishlist/wishlist')->loadByCustomer($customer, true);
                $ids = array();

                foreach ($wishlist->getItemCollection() as $item) {
                    $ids[] = $item->getProductId();
                }
                self::$wishListIds = array_flip($ids);
            }
        }

        if ( isset(self::$wishListIds[$product->getId()]) ) {
            return true;
        }

        return false;
    }

    public function isInCompareList($product) {
        if ( empty(self::$comparingProductsIds) ) {
            $collection = Mage::getResourceModel('catalog/product_compare_item_collection')
                ->useProductItem(true)
                ->setStoreId(Mage::app()->getStore()->getId());

            if (Mage::getSingleton('customer/session')->isLoggedIn()) {
                $collection->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId());
            } else {
                $collection->setVisitorId(Mage::getSingleton('log/visitor')->getId());
            }

            $ids = array();

            foreach ($collection as $comparingProduct) {
                $ids[] = $comparingProduct->getId();
            }
            self::$comparingProductsIds = array_flip($ids);
        }


        if ( isset(self::$comparingProductsIds[$product->getId()]) ) {
            return true;
        }

        return false;
    }

    public function getTopmenuPosition(){
        $position = Mage::getStoreConfig('ecomitize_all_options/topmenu/topmenu_position');

        if(!$position){
            $position = 'default';
        }
        return $position;
    }

    public function getOffsetTop(){
        $offsetTop = Mage::getStoreConfig('ecomitize_all_options/topmenu/topmenu_offset_top');

        if(!$offsetTop){
            $offsetTop = 350;
        }
        return $offsetTop;
    }

}