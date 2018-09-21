<?php

class Ecomitize_All_Block_Adminhtml_Page_Menu extends Mage_Adminhtml_Block_Page_Menu
{
    public function getMenuLevel($menu, $level = 0)
    {
        $systemItem = '';
        $html = '<ul ' . (!$level ? 'id="nav"' : '') . '>' . PHP_EOL;
        foreach ($menu as $item) {
            $li = '';
            $li .= '<li ' . (!empty($item['children']) ? 'onmouseover="Element.addClassName(this,\'over\')" '
                    . 'onmouseout="Element.removeClassName(this,\'over\')"' : '') . ' class="'
                . (!$level && !empty($item['active']) ? ' active' : '') . ' '
                . (!empty($item['children']) ? ' parent' : '')
                . (!empty($level) && !empty($item['last']) ? ' last' : '')
                . ' level' . $level . '"> <a href="' . $item['url'] . '" '
                . (!empty($item['title']) ? 'title="' . $item['title'] . '"' : '') . ' '
                . (!empty($item['click']) ? 'onclick="' . $item['click'] . '"' : '') . ' class="'
                . ($level === 0 && !empty($item['active']) ? 'active' : '') . '"><span>'
                . $this->escapeHtml($item['label']) . '</span></a>' . PHP_EOL;

            if (!empty($item['children'])) {
                $li .= $this->getMenuLevel($item['children'], $level + 1);
            }
            $li .= '</li>' . PHP_EOL;
            if( strtolower ($this->escapeHtml($item['label'])) != 'system'){
                $html .=$li;
            }else{
                $systemItem ='<ul id="nav" class="'.$this->escapeHtml($item['label']).'">'. $li.'</ul>';
            }
            unset($li);
        }
        $html .= '</ul>' . PHP_EOL;

        return $html.$systemItem;
    }
}