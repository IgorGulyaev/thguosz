<?php

class Ecomitize_All_Block_Core_Messages extends Mage_Core_Block_Messages {

    public function isError() {
        return (bool)$this->getMessages(Mage_Core_Model_Message::ERROR);
    }

    public function isWarning() {
        return (bool)$this->getMessages(Mage_Core_Model_Message::WARNING);
    }

    public function isNotice() {
        return (bool)$this->getMessages(Mage_Core_Model_Message::NOTICE);
    }

    public function isSuccess() {
        return (bool)$this->getMessages(Mage_Core_Model_Message::SUCCESS);
    }

}