<?php

namespace LifeOrganizer\Factory;

use Prooph\Common\Event\ActionEventEmitter;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStore\EventStore;
use Prooph\EventStoreBusBridge\EventPublisher;

class EventStoreFactory
{
    public function create()
    {
        /** @var EventStore $eventStore */
        $eventStore = $this->container->get('mysql_event_store');
        /** @var ActionEventEmitter $actionEventEmitter */
        $actionEventEmitter = $this->container->get(
            'prooph_action_event_emitter'
        );
        /** @var EventPublisher */
        $eventPublisher = $this->container->get('event_publisher');

        $eventStore = new ActionEventEmitterEventStore(
            $eventStore,
            $actionEventEmitter
        );

        $eventPublisher->attachToEventStore($eventStore);

        return $eventStore;
    }
}
