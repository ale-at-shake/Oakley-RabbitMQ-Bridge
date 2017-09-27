<?php
/**
 * Created by PhpStorm.
 * User: alessandro.massobrio
 * Date: 27/09/17
 * Time: 23:18
 */
namespace Rcason\MqOakley\Controller\Hello;

class World extends \Magento\Framework\App\Action\Action
{
    public function execute() {
        $textDisplay = new \Magento\Framework\DataObject(
            array('text' => 'Mageplaza'));
        $this->_eventManager->dispatch('checkout_onepage_controller_success_action', ['text' => $textDisplay]);
        echo $textDisplay->getText(); exit;
    }
}