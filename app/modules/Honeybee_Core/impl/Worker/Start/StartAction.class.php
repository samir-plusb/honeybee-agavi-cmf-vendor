<?php

use Honeybee\FrameworkBinding\Agavi\App\Base\Action;
use Honeybee\Infrastructure\Config\ArrayConfig;
use Honeybee\Infrastructure\Event\Bus\Transport\JobQueueTransport;
use Honeybee\Infrastructure\Job\Worker\Worker;

class Honeybee_Core_Worker_StartAction extends Action
{
    const COMMAND_WORKER = 'command';

    const EVENT_WORKER = 'event';

    const DEFAULT_EVENT_EXCHANGE = 'honeybee.domain.events';

    const DEFAULT_COMMAND_EXCHANGE = 'honeybee.domain.commands';

    const DEFAULT_WAIT_EXCHANGE = 'honeybee.domain.waiting';

    const DEFAULT_WAIT_QUEUE = 'honeybee.events.waiting';

    const GLOBAL_QUEUE = '.global';

    public function execute(AgaviRequestDataHolder $request_data)
    {
        $service_locator = $this->getServiceLocator();
        $connector_service = $service_locator->getConnectorService();

        $worker_state = [
            ':connector' => $connector_service->getConnector('Default.MsgQueue'),
            ':config' => $this->buildWorkerConfig($request_data)
        ];

        $service_locator->createEntity(Worker::CLASS, $worker_state)->run();

        return AgaviView::NONE;
    }

    protected function buildWorkerConfig(AgaviRequestDataHolder $request_data)
    {
        $worker_type = $request_data->getParameter('type');
        if ($worker_type === self::COMMAND_WORKER) {
            $default_exchange = self::DEFAULT_COMMAND_EXCHANGE;
            $bindings = $this->buildCommandBindings();
        } else {
            $default_exchange = self::DEFAULT_EVENT_EXCHANGE;
            if ($request_data->hasParameter('binding')) {
                $bindings = [ trim($request_data->getParameter('binding')) ];
            } else {
                $bindings = [ JobQueueTransport::DEFAULT_MSG_ROUTE ];
            }
        }

        $exchange = $request_data->getParameter('exchange', $default_exchange);
        $queue = $request_data->getParameter('queue', $exchange . self::GLOBAL_QUEUE);

        return new ArrayConfig([
            'exchange' => $exchange,
            'queue' => $queue,
            'wait_exchange' => self::DEFAULT_WAIT_EXCHANGE,
            'wait_queue' => self::DEFAULT_WAIT_QUEUE,
            'bindings' => $bindings
        ]);
    }

    protected function buildCommandBindings()
    {
        $command_bus = $this->getServiceLocator()->getCommandBus();
        $bindings = [];

        foreach ($command_bus->getSubscriptions() as $subscription) {
            $bindings[] = $subscription->getCommandType();
        }

        return $bindings;
    }
}
