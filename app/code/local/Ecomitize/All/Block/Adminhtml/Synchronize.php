<?php

class Ecomitize_All_Block_Adminhtml_Synchronize extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /*
     * Set template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('system/config/button.phtml');
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }


    public function getButtonHtml()
    {
        $url = Mage::helper('adminhtml')->getUrl('adminhtml/adminhtml_synchronize/index');

        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => 'synchronize_ln_with_categories',
                'label'     => $this->helper('adminhtml')->__('Synchronize'),
                'onclick'   => "setLocation('$url')"
            ));

        return $button->toHtml();
    }
}