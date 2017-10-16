<?php

namespace AleAbstract\MqOakley\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Magento\Framework\App\State;
use Magento\Framework\Event\Manager as EventManager;
use Magento\Sales\Api\OrderRepositoryInterface;

class OrdersQueueCommand extends Command
{
    const COMMAND_ORDERS_QUEUE = 'mqoakley:orders:queue';
    const ARGUMENT_ORDER_IDS = 'orderIds';
    const OPTION_AREA = 'area';

    /**
     * @var EventManager
     */
    private $eventManager;
    
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;
    
    /**
     * @var State
     */
    protected $state;

    /**
     * @param EventManager $eventManager
     * @param OrderRepositoryInterface $orderRepository
     * @param State $state
     * @param string|null $name
     */
    public function __construct(
        EventManager $eventManager,
        OrderRepositoryInterface $orderRepository,
        State $state,
        $name = null
    ) {
        $this->eventManager = $eventManager;
        $this->orderRepository = $orderRepository;
        $this->state = $state;
        
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $orderIds = explode(
            ',',
            $input->getArgument(self::ARGUMENT_ORDER_IDS)
        );
        $area = $input->getOption(self::OPTION_AREA);

        try {
            $this->state->setAreaCode($area);
        } catch(\Exception $ex) {
            $output->writeln('Error setting area: ' . $ex->getMessage());
        }
        
        foreach($orderIds as $orderId) {
            $order = $this->orderRepository->get($orderId);
            $this->eventManager->dispatch(
                'sales_order_save_after',
                ['order' => $order]
            );
        }
        
        $output->writeln('Events dispatched.');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_ORDERS_QUEUE);
        $this->setDescription('Queue orders by id');
        
        $this->addArgument(
            self::ARGUMENT_ORDER_IDS,
            InputArgument::REQUIRED,
            'The order ids, separated by comma.'
        );
        $this->addOption(
            self::OPTION_AREA,
            null,
            InputOption::VALUE_REQUIRED,
            'The area to use (adminhtml or frontend).',
            'frontend'
        );
        
        parent::configure();
    }
}
