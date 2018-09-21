<?php

class Ecomitize_All_Block_Banner_Adminhtml_Bannergroup_Edit_Tab_Form extends Uni_Banner_Block_Adminhtml_Bannergroup_Edit_Tab_Form
{
    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('bannergroup_form', array('legend' => Mage::helper('banner')->__('Item information')));
        $animations = Mage::getSingleton('banner/status')->getAnimationArray();
        $preAnimations = Mage::getSingleton('banner/status')->getPreAnimationArray();


        $fieldset->addField('group_name', 'text', array(
            'label' => Mage::helper('banner')->__('Banner Group Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'group_name',
        ));

        if (Mage::registry('bannergroup_data')->getId() == null) {
            $fieldset->addField('group_code', 'text', array(
                'label' => Mage::helper('banner')->__('Banner Group Code'),
                'class' => 'required-entry',
                'name' => 'group_code',
                'required' => true,
            ));
        }

        $fieldset->addField('masterslider', 'select', array(
            'label' => Mage::helper('banner')->__('Masterslider'),
            'name' => 'masterslider',
            'values' => array(
                array(
                    'value' => 0,
                    'label' => Mage::helper('banner')->__('Disabled'),
                ),
                array(
                    'value' => 1,
                    'label' => Mage::helper('banner')->__('Enabled'),
                ),
            ),
        ));

        $fieldset->addField('pre_banner_effects', 'select', array(
            'label' => Mage::helper('banner')->__('Pre-Defined Banner Effects'),
            'name' => 'pre_banner_effects',
            'required' => true,
            'values' => $preAnimations
        ));

        $fieldset->addField('show_title', 'select', array(
            'label' => Mage::helper('banner')->__('Display Title'),
            'class' => 'required-entry',
            'name' => 'show_title',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('banner')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('show_content', 'select', array(
            'label' => Mage::helper('banner')->__('Display Content'),
            'class' => 'required-entry',
            'name' => 'show_content',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('banner')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('banner')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('link_target', 'select', array(
            'label' => Mage::helper('banner')->__('Target'),
            'name' => 'link_target',
            'values' => array(
                array(
                    'value' => 0,
                    'label' => Mage::helper('banner')->__('Disabled'),
                ),
                array(
                    'value' => 1,
                    'label' => Mage::helper('banner')->__('New Window'),
                ),
            ),
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('banner')->__('Status'),
            'class' => 'required-entry',
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('banner')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('banner')->__('Disabled'),
                ),
            ),
        ));

        $fieldset->addField('auto_scroll', 'select', array(
            'label' => Mage::helper('banner')->__('Auto scroll'),
            'name' => 'auto_scroll',
            'values' => array(
                array(
                    'value' => 0,
                    'label' => Mage::helper('banner')->__('Disabled'),
                ),
                array(
                    'value' => 1,
                    'label' => Mage::helper('banner')->__('Enabled'),
                ),
            ),
        ));

        $fieldset->addField('slider', 'select', array(
            'label' => Mage::helper('banner')->__('Slider'),
            'name' => 'slider',
            'values' => array(
                array(
                    'value' => 0,
                    'label' => Mage::helper('banner')->__('Disabled'),
                ),
                array(
                    'value' => 1,
                    'label' => Mage::helper('banner')->__('Enabled'),
                ),
            ),
        ));

        $fieldset->addField('random', 'select', array(
            'label' => Mage::helper('banner')->__('Random'),
            'name' => 'random',
            'values' => array(
                array(
                    'value' => 0,
                    'label' => Mage::helper('banner')->__('Disabled'),
                ),
                array(
                    'value' => 1,
                    'label' => Mage::helper('banner')->__('Enabled'),
                ),
            ),
        ));

        $fieldset->addField('random_count', 'text', array(
            'label' => Mage::helper('banner')->__('Random Count'),
            'name' => 'random_count',
        ));

        $fieldset->addField('active_item', 'select', array(
            'label' => Mage::helper('banner')->__('Active item'),
            'name' => 'active_item',
            'values' => $this->getBanners()
        ));

        $fieldset->addField('auto_scroll_timeout', 'text', array(
            'label' => Mage::helper('banner')->__('Auto scroll timeout'),
            'name' => 'auto_scroll_timeout',
        ));

        if (Mage::getSingleton('adminhtml/session')->getBannergroupData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBannergroupData());
            Mage::getSingleton('adminhtml/session')->setBannergroupData(null);
        } elseif (Mage::registry('bannergroup_data')) {
            $data = Mage::registry('bannergroup_data')->getData();

            if ( !$data['random_count'] ) {
                $data['random_count'] = 1;
            }

            $form->setValues($data);
        }
        $grandparent = $this->getGrandParentClass($this);

        return $grandparent::_prepareForm();
    }

    private function getGrandParentClass($object) {
        if (is_object($object)) {
            $className = get_class($object);
        }
        return get_parent_class(get_parent_class($className));
    }

    public function getBannergroupData() {
        return Mage::registry('bannergroup_data');
    }

    public function getBanners() {
        $bannersId = explode(',', $this->getBannergroupData()->getBannerIds());
        $banners = Mage::getModel('banner/banner')->getCollection()
            ->addFieldToFilter('banner_id', array('in' => $bannersId));

        $data = array( array(
            'value' => 0,
            'label' => Mage::helper('banner')->__('Disabled')
        ));

        foreach ($banners as $banner) {
            $data[] = array(
                'value' => $banner->getId(),
                'label' => Mage::helper('banner')->__($banner->getTitle())
            );
        }

        return $data;
    }
}