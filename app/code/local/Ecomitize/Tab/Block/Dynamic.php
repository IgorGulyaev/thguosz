<?php
class Ecomitize_Tab_Block_Dynamic
    extends Mage_Core_Block_Template
{

    protected $_template = 'tab/product_template.phtml';
    protected $name;


    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    public function getProductCollection()
    {
        $storeId  = Mage::app()->getStore()->getId();

        $products = Mage::getResourceModel('catalog/product_collection')
            ->setStoreId($storeId)
            ->addAttributeToFilter($this->name, array('eq' => '1'))
            ->addAttributeToSelect('image')
            ->addAttributeToSelect('name')
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->setPageSize(5)
            ->addAttributeToSort('position', 'desc');

        if ($curCat = Mage::registry('current_category')) {
            $products->addCategoryFilter($curCat)
                ->addUrlRewrite($curCat->getId());
        }

        Mage::getSingleton('catalog/product_status')
            ->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')
            ->addVisibleInCatalogFilterToCollection($products);

        return $products;
    }
};