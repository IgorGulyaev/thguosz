<?php
/**
 * Product renderer
 *
 * Class Ecomitize_All_Block_Product_Renderer
 */
class Ecomitize_All_Block_Product_Renderer extends Mage_Catalog_Block_Product_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('catalog/product/general_item_view.phtml');
    }

    public function getIsListMode() {
        $toolbar = $this->getLayout()->getBlock('product_list_toolbar');

        if ( !$toolbar ) {
            return false;
        }

        $mode = $toolbar->getCurrentMode();

        if ( $mode === 'grid' ) {
            return false;
        }
        return true;
    }
}