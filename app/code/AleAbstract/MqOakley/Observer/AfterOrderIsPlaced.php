<?php

namespace AleAbstract\MqOakley\Observer;

use Magento\Framework\Event\ObserverInterface;
use Rcason\Mq\Api\PublisherInterface;

class AfterOrderIsPlaced implements ObserverInterface
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
        $this->publisher->publish('from-magento', 'it works');
    }
}