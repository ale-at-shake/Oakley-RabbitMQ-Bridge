<?php
/**
 * Created by PhpStorm.
 * User: alessandro.massobrio
 * Date: 26/09/17
 * Time: 14:47
 */

namespace Rcason\MqOakley\Observer;
use Magento\Framework\Event\ObserverInterface;
use Rcason\Mq\Api\PublisherInterface;
class OrderSaveAfter implements ObserverInterface
{
    /**
     * @var PublisherInterface
     */
    private $publisher;

    /**
     * @param PublisherInterface $publisher
     */
    public function __construct(
        PublisherInterface $publisher
    ) {
        $this->publisher = $publisher;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        var_dump('ALE!');
        $this->publisher->publish('from-magento', 42);
    }
}