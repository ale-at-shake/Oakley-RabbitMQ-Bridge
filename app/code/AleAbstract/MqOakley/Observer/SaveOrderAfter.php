<?php

namespace AleAbstract\MqOakley\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderExtensionInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\ShippingAssignmentInterface;
use Magento\Sales\Model\Order\ShippingAssignmentBuilder;

use Rcason\Mq\Api\PublisherInterface;

class SaveOrderAfter implements ObserverInterface
{
    /**
     * @var OrderExtensionFactory
     */
    private $orderExtensionFactory;

    /**
     * @var ShippingAssignmentBuilder
     */
    private $shippingAssignmentBuilder;
    
    /**
     * @var PublisherInterface
     */
    private $publisher;
    
    /**
     * @param OrderExtensionFactory $orderExtensionFactory
     * @param ShippingAssignmentBuilder $shippingAssignmentBuilder
     * @param PublisherInterface $publisher
     */
    public function __construct(
        OrderExtensionFactory $orderExtensionFactory,
        ShippingAssignmentBuilder $shippingAssignmentBuilder,
        PublisherInterface $publisher
    ) {
        $this->orderExtensionFactory = $orderExtensionFactory;
        $this->shippingAssignmentBuilder = $shippingAssignmentBuilder;
        $this->publisher = $publisher;
    }
    
    /**
     * {@inheritdoc}
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $order = $observer->getEvent()->getOrder();

        // Populate shipping assignments
        $this->setShippingAssignments($order);

        // Publish to queue
        $this->publisher->publish('from-magento', $order);
    }
    
    /**
     * @param OrderInterface $order
     * @return void
     */
    private function setShippingAssignments(OrderInterface $order)
    {
        /** @var OrderExtensionInterface $extensionAttributes */
        $extensionAttributes = $order->getExtensionAttributes();

        if ($extensionAttributes === null) {
            $extensionAttributes = $this->orderExtensionFactory->create();
        } elseif ($extensionAttributes->getShippingAssignments() !== null) {
            return;
        }
        
        /** @var ShippingAssignmentInterface $shippingAssignment */
        $this->shippingAssignmentBuilder->setOrderId($order->getEntityId());
        $extensionAttributes->setShippingAssignments(
            $this->shippingAssignmentBuilder->create()
        );
        $order->setExtensionAttributes($extensionAttributes);
    }
}
