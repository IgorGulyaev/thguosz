<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 17.03.16
 * Time: 16:05
 */

class Ecomitize_All_Block_System_Config_Form_Field_Color extends Mage_Adminhtml_Block_System_Config_Form_Field {



    /**
     * Enter description here...
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setClass('jscolor ' .$element->getClass());
        $html = '<input id="'.$element->getHtmlId().'" name="'.$element->getName()
            .'" value="'.$element->getEscapedValue().'" '.$element->serialize($element->getHtmlAttributes()).'/>'."\n";
        $html.= $element->getAfterElementHtml();
        return $html;

    }

}