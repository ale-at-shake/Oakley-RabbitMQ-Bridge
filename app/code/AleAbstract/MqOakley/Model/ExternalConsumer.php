<?php

namespace AleAbstract\MqOakley\Model;

class ExternalConsumer implements \Rcason\Mq\Api\ConsumerInterface
{
    protected $logger;
    
    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }
    
    /**
     * {@inheritdoc}
     */
    public function process($productId)
    {
        throw new \Exception('This queue should not be processed by a Magento consumer.');
    }
}
