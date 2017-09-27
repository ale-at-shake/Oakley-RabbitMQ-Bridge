<?php
/**
 * Created by PhpStorm.
 * User: alessandro.massobrio
 * Date: 28/09/17
 * Time: 00:37
 */
namespace Rcason\MqOakley\Model;
class OakleyPublisher implements \Rcason\Mq\Api\PublisherInterface
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
     * Publish message to queue
     */
    public function publish($queueName, $messageContent)
    {
        // TODO: Implement publish() method.
    }
}