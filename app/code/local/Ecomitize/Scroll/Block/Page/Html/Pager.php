<?php
class Ecomitize_Scroll_Block_Page_Html_Pager extends Mage_Page_Block_Html_Pager
{
    private $arrayPages = null;

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('scroll/pager.phtml');
    }

    protected function getActivePagesFromRequest() {
        $pages = Mage::app()->getRequest()->getParam('pages');

        if ( isset($pages) ) {
            $this->arrayPages = explode(',', $pages);
        } else {
            $this->arrayPages = array();
        }
    }

    protected function getActivePages() {
        if ( is_null($this->arrayPages) ) {
            $this->getActivePagesFromRequest();
        }
        return $this->arrayPages;
    }

    protected function removePagesFromUrl($url) {
        return preg_replace('/&?pages=[^&]*/', '', $url);
    }
}