<?php

require_once 'Uni/Banner/controllers/Adminhtml/BannergroupController.php';


class Ecomitize_All_Adminhtml_Adminhtml_BannergroupController extends Uni_Banner_Adminhtml_BannergroupController
{
    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $banners = array();
            $availBannerIds = Mage::getModel('banner/banner')->getAllAvailBannerIds();
            parse_str($data['bannergroup_banners'], $banners);
            foreach ($banners as $k => $v) {
                if (preg_match('/[^0-9]+/', $k) || preg_match('/[^0-9]+/', $v)) {
                    unset($banners[$k]);
                }
            }
            $bannerIds = array_intersect($availBannerIds, $banners);
            $data['banner_ids'] = implode(',', $bannerIds);
            $model = Mage::getModel('banner/bannergroup');
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));

            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                        ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banner')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }
}