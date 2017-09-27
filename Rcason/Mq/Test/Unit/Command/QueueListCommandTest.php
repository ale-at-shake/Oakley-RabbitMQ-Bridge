<?php

namespace Rcason\Mq\Test\Unit\Console;

use Rcason\Mq\Console\QueueListCommand;

class QueueListCommandTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager */
    private $objectManager;

    /**
     * @var QueueListCommand
     */
    private $command;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        parent::setUp();
    }

    /**
     * Test configure() method implicitly via construct invocation.
     *
     * @return void
     */
    public function testConfigure()
    {
        $this->command = $this->objectManager->getObject('Rcason\Mq\Console\QueueListCommand');

        $this->assertEquals(QueueListCommand::COMMAND_QUEUE_LIST, $this->command->getName());
        $this->assertEquals('List of defined queues', $this->command->getDescription());
    }
}
