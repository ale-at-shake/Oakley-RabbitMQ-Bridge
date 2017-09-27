<?php

namespace Rcason\Mq\Test\Unit\Console;

use Rcason\Mq\Console\BrokerListCommand;

class BrokerListCommandTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager */
    private $objectManager;

    /**
     * @var BrokerListCommand
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
        $this->command = $this->objectManager->getObject('Rcason\Mq\Console\BrokerListCommand');

        $this->assertEquals(BrokerListCommand::COMMAND_BROKER_LIST, $this->command->getName());
        $this->assertEquals('List of defined brokers', $this->command->getDescription());
    }
}
