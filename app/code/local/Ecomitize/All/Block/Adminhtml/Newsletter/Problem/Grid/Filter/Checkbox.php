<?php
class Ecomitize_All_Block_Adminhtml_Newsletter_Problem_Grid_Filter_Checkbox extends Mage_Adminhtml_Block_Newsletter_Problem_Grid_Filter_Checkbox
{
    public function getHtml()
    {
        return '<span class="checkbox"><input type="checkbox" onclick="problemController.checkCheckboxes(this)"/><span></span></span>';
    }
}