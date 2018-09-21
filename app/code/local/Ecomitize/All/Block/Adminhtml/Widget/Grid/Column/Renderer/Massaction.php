<?php

class Ecomitize_All_Block_Adminhtml_Widget_Grid_Column_Renderer_Massaction extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Massaction
{
    protected function _getCheckboxHtml($value, $checked)
    {
        $html = '<span class="checkbox-container"><input type="checkbox" name="' . $this->getColumn()->getName() . '" ';
        $html .= 'value="' . $this->escapeHtml($value) . '" class="massaction-checkbox"' . $checked . '/><span></span></span>';
        return $html;
    }

}