<?php
class Ecomitize_Tab_Block_Tab
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{

    protected $_template = 'tab/tabs.phtml';
    protected $attributes = [];

    public function getViewed()
    {
        $blockIndexFeatured = $this
            ->getLayout()
            ->createBlock('reports/product_viewed', 'home.reports.product.viewed')
            ->setTemplate('tab/home_product_viewed.phtml')
        ;

        return $blockIndexFeatured;

    }

    public function getFeatures()
    {
        $featuredProducts = $this->getLayout()->createBlock('ecomitize_all/filterproducts_featured', 'featured_products')
            ->setTemplate('catalog/product/list/featured.phtml');

        $productRenderer = $this->getLayout()->createBlock('ecomitize_all/product_renderer', 'product_renderer')->setImageType('image');

        $featuredProducts->append($productRenderer);

        return $featuredProducts;
    }

    public function getSales()
    {
        $salesProducts = $this->getLayout()->createBlock('ecomitize_all/filterproducts_sale', 'on_sale_products')
            ->setTemplate('catalog/product/list/onsale.phtml');

        $productRenderer = $this->getLayout()->createBlock('ecomitize_all/product_renderer', 'product_renderer');

        $salesProducts->append($productRenderer);

        return $salesProducts;
    }

    public function getBlock($name)
    {
        Switch ($name) {
            case 'sale':
                return $this->getSales();
            case 'featured':
                return $this->getFeatures();
            case 'viewed':
                return $this->getViewed();
        }

        $mainBlock = $this->getLayout()->createBlock('ecomitize_tab/dynamic', $name . '_products')
            ->setName($name);

        $productRenderer = $this->getLayout()->createBlock('ecomitize_all/product_renderer', 'product_renderer');

        $mainBlock->append($productRenderer);

        return $mainBlock;
    }

    public function addArgs($attribute, $title, $active=false)
    {
        $this->attributes[] = [
            'active' => $active == 'true' ? true : false,
            'title' => $title,
            'attribute' => $attribute
        ];
    }

    private function setActive()
    {
        $keyChange = 0;

        foreach ( $this->attributes as $key => $attribute ) {
            if ( $attribute['active'] ) {
                $keyChange= $key;
                break;
            }
        }

        if ( !($keyChange === 0) ) {
            list($this->attributes[0], $this->attributes[$keyChange]) = array($this->attributes[$keyChange], $this->attributes[0]);
        }
    }



    protected function _toHtml()
    {
        if (empty($this->attributes)) {
            $tab_options = unserialize($this->getData('tab_options'));

            $comparator = function ($a, $b)
            {
                if ($a['tab_sort'] == $b['tab_sort']) {
                    return 0;
                }

                return ($a['tab_sort'] < $b['tab_sort']) ? -1 : 1;
            };

            usort($tab_options,  $comparator);

            $this->attributes = $tab_options;
        } else {
            $this->setActive();
        }

        foreach ( $this->attributes as $key => $attribute ) {
            if ( $attribute['attribute'] === 'viewed' ) {

                $products = Mage::getBlockSingleton('reports/product_viewed')->getItemsCollection();

                if ( count($products) == 0 ) {
                    unset($this->attributes[$key]);
                }
                break;
            }
        }

        $this->attributes = array_values($this->attributes);

        return parent::_toHtml();
    }
};