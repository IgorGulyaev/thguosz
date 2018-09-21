<?php

class Ecomitize_Tab_Block_Adminhtml_System_Config_Taboptions
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{
    /** @var  Ecomitize_Tab_Block_Adminhtml_System_Config_Field_Tab */
    protected $_tabRenderer;

    public function _prepareToRender()
    {
        $this->addColumn('attribute', array(
            'label' => Mage::helper('ecomitize_tab')->__('Attribute'),
            'renderer' => $this->_getTabRenderer(),
            'style' => 'width:120px'
        ));

        $this->addColumn('title', array(
            'label' => Mage::helper('ecomitize_tab')->__('Title'),
            'style' => 'width:120px'
        ));

        $this->addColumn('tab_sort', array(
            'label' => Mage::helper('ecomitize_tab')->__('Sort'),
            'style' => 'width:120px'
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('ecomitize_tab')->__('Add New Item');
    }

    protected function  _getTabRenderer()
    {
        if (!$this->_tabRenderer) {
            $this->_tabRenderer = $this->getLayout()->createBlock(
                'ecomitize_tab/adminhtml_system_config_field_tab', '',
                array('is_render_to_js_template' => true)
            );
        }
        return $this->_tabRenderer;
    }

    protected function _prepareArrayRow(Varien_Object $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->_getTabRenderer()
                ->calcOptionHash($row->getData('attribute')),
            'selected="selected"'
        );
    }
}
