<?php

class Ecomitize_All_Block_Product_Tab extends Mage_Catalog_Block_Product_View
{
    public function getAttributeInfo(Array $attributeCodes,$_product)
    {
        $attributeArray = [];
        $attributes = $_product->getAttributes();
        foreach ($attributes as $attribute) {
            if(in_array($attribute->getAttributeCode(), $attributeCodes )){
                $label = $attribute->getStoreLabel($_product);
                $value = $attribute->getFrontend()->getValue($_product);
                $attributeArray[] =$label . ' ' . $value;
            }
        }
        
        return $attributeArray;
    }
}