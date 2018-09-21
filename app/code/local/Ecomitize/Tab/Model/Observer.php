<?php

class Ecomitize_Tab_Model_Observer {

    public function saveBefore(Varien_Event_Observer $observer)
    {
        $widget = $observer->getDataObject();
        $params = $widget->getWidgetParameters();

        if ( isset($params['tab_options']['__empty']) ) {
            unset($params['tab_options']['__empty']);
        }

        $observer->getDataObject()->setWidgetParameters(
            serialize($params)
        );
    }
}