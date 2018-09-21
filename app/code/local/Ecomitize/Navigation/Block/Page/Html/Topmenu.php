<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Page
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Top menu block
 *
 * @package    Ecomitize_All
 * @author     Ecomitizet Magento Team <>
 * @copyright  Copyright (c) 2015 Ecomitize http://www.ecomitize.com
 */
class Ecomitize_Navigation_Block_Page_Html_Topmenu extends Mage_Page_Block_Html_Topmenu
{
    private $_topMenuType;

    public function __construct(array $args)
    {
        parent::__construct($args);
        $this->_topMenuType = Mage::getStoreConfig('ecomitize_all_options/topmenu/topmenu_type_option');
    }

    private function _getBanner($bannerGroupCode)
    {

        $bannerBlock = Mage::app()->getLayout()
            ->createBlock('banner/banner', 'menuBanner')
            ->setBannerGroupCode($bannerGroupCode)
            ->setBannerImgMaxWidth(1000);

        $cmsBlockBanner = Mage::app()->getLayout()
            ->createBlock('core/template', 'cms.block.menu.banner')
            ->insert($bannerBlock)
            ->getChildHtml();

        return $cmsBlockBanner;

    }

    /**
     * Recursively generates top menu html from data that is specified in $menuTree
     *
     * @param Varien_Data_Tree_Node $menuTree
     * @param string $childrenWrapClass
     * @return string
     */
    protected function _getHtml(Varien_Data_Tree_Node $menuTree, $childrenWrapClass, $isCategoryLink = true)
    {
        $html = '';

        $_menuCategoryImageBasePath = Mage::getSingleton('ecomitize_all/category_attribute_backend_image')->getMenuImageUrl();

        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $nodes = $children->getNodes();
        if ($nodes && is_array($nodes)) {
            $lastNode = end($nodes);
        }
        $childLevel = is_null($parentLevel) ? 0 : $parentLevel + 1;

        $counter = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';
        $menuImages = array();

        if ($this->_topMenuType == 'wrap') {

            $categories = Mage::getResourceModel('catalog/category_collection')
                ->addAttributeToSelect('id')
                ->addAttributeToSelect('menu_category_image')
                ->addAttributeToSelect('menu_category_image_alt')
                ->addAttributeToSelect('menu_category_image_link')
                ->addAttributeToSelect('menu_banner');

            foreach ($categories as $category) {

                $_menuCategoryImageHref = $category->getMenuCategoryImageLink();
                $_menuCategoryImagePath = $category->getMenuCategoryImage();
                $_menuCategoryImageAlt = $category->getMenuCategoryImageAlt();
                $_menuCategoryBanner = $category->getMenuBanner();

                if ($_menuCategoryImageHref && $_menuCategoryImagePath) {
                    $menuImages['category-node-' . $category->getId()] = '<div class="dropdown-banner hidden-xs"><a href="' . $_menuCategoryImageHref . '"><img alt="' . $_menuCategoryImageAlt . '" src= "' . $_menuCategoryImageBasePath . $_menuCategoryImagePath . '"></a></div>';
                } else {
                    $menuImages['category-node-' . $category->getId()] = false;
                }

                if ($_menuCategoryBanner) {
                    $menuBanner['category-node-' . $category->getId()] = $_menuCategoryBanner;
                } else {
                    $menuBanner['category-node-' . $category->getId()] = false;
                }
            }
        }

        foreach ($children as $child) {
            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);

            if ($this->_topMenuType == 'wrap' && ((isset($menuImages[$child->getId()]) && isset($menuBanner[$child->getId()])) && ($menuImages[$child->getId()] || $menuBanner[$child->getId()]))) {
                $wrapMenuFlag = true;
            } else {
                $wrapMenuFlag = false;
            }
            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            if ($childLevel == 0 && $outermostClass) {
                $outermostClassCode = ' class="' . $outermostClass . ($child->hasChildren() ? ' dropdown-toggle" data-hover="dropdown" ' : '"');
                $child->setClass($outermostClass);
            }

            $html .= '<li data-submenu-id="submenu-' . $child->getId() . '" ' . ($childLevel == 0 ? $this->getTopClassName($counter, $childrenCount, $this->_getRenderedMenuItemAttributes($child)) : $this->_getRenderedMenuItemAttributes($child)) . '>';
            $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '>' . $this->escapeHtml($child->getName()) . '</a>';

            if ($child->hasChildren()) {
                if ($wrapMenuFlag) {
                    $html .= '<div class="' . $childrenWrapClass . ' dropdown-menu dropdown-wraper' . '">';
                    $html .= '<div class="dropdown-wraper-inner">';
                }
                if ($childLevel < 3) {

                    if ($childLevel == 1) {
                        list($childLeft, $childRight) = $this->splitTree($child);
                        $html .= '<div class="dropdown-wrap">';
                        $html .= '<div class="dropdown-wrap-left">';
                        $html .= '<ul id="' . $child->getId() . '" class="level' . $childLevel . ' ' . (isset($menuImages[$child->getId()]) && $menuImages[$child->getId()] ? 'dropdown-menu' : 'dropdown-menu') . '">';
                        $html .= $this->_getHtml($childLeft, $childrenWrapClass, (count($child->getChildren()->getNodes()) > 1) ? false : true);
                        $html .= '</ul>';
                        $html .= '</div>';
                        $html .= '<div class="dropdown-wrap-right">';
                        $html .= '<ul id="' . $child->getId() . '" class="level' . $childLevel . ' ' . (isset($menuImages[$child->getId()]) && $menuImages[$child->getId()] ? 'dropdown-menu' : 'dropdown-menu') . '">';
                        $html .= $this->_getHtml($childRight, $childrenWrapClass);
                        $html .= '</ul>';
                        $html .= '</div>';
                        $html .= '</div>';
                    } else {
                        $html .= '<ul id="' . $child->getId() . '" class="level' . $childLevel . ' ' . (isset($menuImages[$child->getId()]) && $menuImages[$child->getId()] ? 'dropdown-menu' : 'dropdown-menu') . '">';
                        $html .= $this->_getHtml($child, $childrenWrapClass);
                        $html .= '</ul>';
                    }

                    if ($childLevel == 0 && $wrapMenuFlag) {
                        if (!$menuBanner[$child->getId()]) {
                            $html .= isset($menuImages[$child->getId()]) ? $menuImages[$child->getId()] : '';
                        }
                        $html .= '<div class="dropdown-banner hidden-xs">' . $this->_getBanner($menuBanner[$child->getId()]) . '</div>';
                    }
                }

                if ($wrapMenuFlag) {
                    $html .= '</div>';
                    $html .= '</div>';
                }
            }
            $html .= '</li>';

            if ($childLevel > 0) {
                if (($lastNode && $child->getId() === $lastNode->getId() && !is_null($child->getId())) && $isCategoryLink) {
                    $html .= '<li ' . 'class="' . 'level' . $childLevel . ' btn-show-all' . '">';
                    $html .= '<a href="' . $child->getParent()->getUrl() . '" ' . '>' . 'All ' . ' ' . $child->getParent()->getName() . '</a>';
                    $html .= '</li>';
                }
            }
            $counter++;
        }

        return $html;
    }

    /**
     * Returns array of menu item's classes
     *
     * @param Varien_Data_Tree_Node $item
     * @return array
     */
    protected function _getMenuItemClasses(Varien_Data_Tree_Node $item)
    {
        $classes = array();

        $classes[] = 'level' . $item->getLevel();
        $classes[] = $item->getPositionClass();

        if ($item->getIsFirst()) {
            $classes[] = 'first';
        }

        if ($item->getIsActive()) {
            $classes[] = 'active';
        }

        if ($item->getIsLast()) {
            $classes[] = 'last';
        }

        if ($item->getClass()) {
            $classes[] = $item->getClass();
        }

        if ($item->hasChildren()) {
            $classes[] = 'dropdown';
        }

        return $classes;
    }

    public function getTopClassName($counter, $childrenCount, $class)
    {

        $quarter = $counter / $childrenCount * 100;
        if ($quarter <= 50) {
            $class = str_replace('class="', 'class="dropdown-left ', $class);
            return $class;
        } elseif ($quarter > 50) {
            $class = str_replace('class="', 'class="dropdown-right ', $class);
            return $class;
        }
    }

    protected function splitTree($child)
    {
        $childrenQuantity = count($child->getChildren()->getNodes());
        $counter = 0;

        $childLeft = new Varien_Data_Tree_Node($child->getData(), $child->getIdField(), $child->getTree(), $child->getParent());
        $childRight = new Varien_Data_Tree_Node($child->getData(), $child->getIdField(), $child->getTree(), $child->getParent());

        foreach ($child->getChildren()->getNodes() as $node) {
            if ($counter >= $childrenQuantity / 2) {
                $childRight->addChild($node);
            } else {
                $childLeft->addChild($node);
            }
            $counter++;
        }

        return array($childLeft, $childRight);
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