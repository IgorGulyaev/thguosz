<?php

class Ecomitize_Popup_Block_Popup extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    protected $_modalType;
    protected $_modalSize;
    protected $_modalTitle;
    protected $_modalAppearanceinterval;
    protected $_modalImage;
    protected $_modalAppearanceTime;
    protected $_modalDisappearanceTime;
    protected $_appearanceinterval;
    protected $_modalVideoFrom;
    protected $_modalVimeoLink;
    protected $_modalYoutubeLink;
    protected $_modalIframeLink;
    protected $_modalIntervalDontshow;
    protected $_modalEnable;
    protected $_modalVideoAutoplay;
    protected $_modalText;

    public function _construct()
    {
        $this->setTemplate('popup/modal.phtml');
        parent::_construct();
    }

    protected function _initModalOptions()
    {
        $this->_modalEnable = $this->getData('popup_enable');
        $this->_modalText = $this->getData('popup_textarea');
        $this->_modalType = $this->getData('popup_type');
        $this->_modalSize = $this->getData('popup_size');
        $this->_modalTitle = $this->getData('popup_title');
        $this->_modalAppearanceinterval = $this->getData('popup_appearanceinterval');
        $this->_modalImage = $this->getData('popup_image');
        $this->_modalAppearanceTime = $this->getData('popup_appearance_time');
        $this->_modalDisappearanceTime = $this->getData('popup_disappearance_time');
        $this->_modalVideoFrom = $this->getData('popup_video_from');
        $this->_modalVimeoLink = $this->getData('popup_vimeo_link');
        $this->_modalYoutubeLink = $this->getData('popup_youtube_link');
        $this->_modalIframeLink = $this->getData('popup_iframe_link');
        $this->_modalIntervalDontshow = $this->getData('popup_interval_dontshow');
        $this->_modalVideoAutoplay = $this->getData('popup_video_autoplay');
        $this->_modalCouponImage = $this->getData('popup_coupon_image');

    }

    protected function _getTitle(){
        return $this->_modalTitle;
    }

    protected function _getEnable(){
        return $this->_modalEnable;
    }

    public function getModalIntervalDontshow(){
        if( $this->getData('popup_interval_dontshow') ){
            return $this->getData('popup_interval_dontshow');
        }else{
            return 0;
        }
    }

    protected function _getModalSizeClass(){
        return 'modal-'.$this->_modalSize;
    }

    protected function _getmodalAppearanceTime()
    {
        if($this->_modalAppearanceTime){
            return $this->_modalAppearanceTime;
        }else{
            return '0.8';
        }
    }

    protected function _getmodalDisappearanceTime()
    {
        if($this->_modalDisappearanceTime){
            return $this->_modalDisappearanceTime;
        }else{
            return '0.8';
        }
    }

    protected function _getModalBody()
    {
        if( $this->_modalType == 'banner'){
            $html = $this->_getBanner();
        }elseif( $this->_modalType == 'subscribe' ){
            $html = $this->_getSubscribe();
        }
//        elseif( $this->_modalType == 'form' ){
//            $html = $this->_getForm();
//        }
        elseif( $this->_modalType == 'iframe' ||  $this->_modalType == 'video' ){
            $html = $this->_getIframe();
        }else{
            $html = '';
        }

        return $html;
    }

    function _getBanner()
    {
        if( $this->_modalImage ){
            $html = '<img width="100%" src="'. Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$this->_modalImage .'" alt="banner">';
        }else{
            $html = '';
        }
        return $html;
    }

    function _getBgBanner($image)
    {
        if( $this->_modalImage ){
            $html = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$image;
        }else{
            $html = '';
        }
        return $html;
    }


    protected function _getSubscribe()
    {
        $subscribeForm = Mage::app()->getLayout()->createBlock('newsletter/subscribe')->setTemplate('newsletter/subscribe.phtml')->toHtml();

        if(!$subscribeForm){
            throw new Exception('Can`t get subscribe block.');
        }


        return $subscribeForm;
    }

    protected function _getForm()
    {
        $form = Mage::app()->getLayout()->createBlock('newsletter/subscribe')->setTemplate('newsletter/subscribe.phtml')->toHtml();
        if(!$form){
            throw new Exception('Can`t get subscribe block.');
        }

        return $form;
    }

    protected function _getCookiesAppearanceinterval()
    {
        return Mage::getModel('core/cookie')->get('appearanceinterval'.$this->getNameInLayout());
    }

    protected function _getCookiesintervaldontshow()
    {
        return Mage::getModel('core/cookie')->get('intervaldontshow'.$this->getNameInLayout());
    }


    protected function _setCookiesAppearanceinterval()
    {
        $interval = 259200;
        if($this->_modalAppearanceinterval){
            $interval = $this->_modalAppearanceinterval;
        }
        return Mage::getModel('core/cookie')->set('appearanceinterval'.$this->getNameInLayout(), 'disappear', $interval);
    }

    protected function _getIframe()
    {
        if($this->_modalSize == 'sm'){
            $width = 260;
            $height = 146;
        }elseif($this->_modalSize == 'md'){
            $width = 560;
            $height = 315;
        }elseif($this->_modalSize == 'lg'){
            $width = 853;
            $height = 480;
        }else{
            $width = 560;
            $height = 315;
        }
        $src = false;

        if($this->_modalType == 'video'){
            $autopalay ='';
            if($this->_modalVideoAutoplay){
                $autopalay = '?autoplay=1';
            }

            if( $this->_modalVideoFrom == 'vimeo' && $this->_modalVimeoLink ){
                $src = 'https://player.vimeo.com/video/'.$this->_modalVimeoLink.$autopalay;

            }elseif( $this->_modalVideoFrom == 'youtube' && $this->_modalYoutubeLink ){
                $src = 'https://www.youtube.com/embed/'.$this->_modalYoutubeLink.$autopalay;
            }

        }elseif( $this->_modalType == 'iframe' && $this->_modalIframeLink ){
            $src = $this->_modalIframeLink;
        }

        if($src){
            $iframe = '<iframe class="popup-video-iframe" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen width="'.$width.'" height="'.$height.'" src="'.$src.'">
                            <p>Your browser does not support iframes.</p>
                       </iframe>';
        }else{
//            throw new Exception('Can`t get src for iframe.');
            $iframe ='';
        }
        return $iframe;

    }

    protected function _toHtml()
    {
        $this->_initModalOptions();
        return parent::_toHtml();
    }
}