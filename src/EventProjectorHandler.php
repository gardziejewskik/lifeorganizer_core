<?php

namespace LifeOrganizer\Core;

use Prooph\EventStore\EventStore;
use Prooph\EventStore\Projection\ReadModelProjector;
use Prooph\EventStore\StreamName;

class EventProjectorHandler
{
    private $projector;

    private $eventStore;

    /** @var bool $projectorInitialized */
    private $projectorInitialized = false;

    public function __construct(
        ReadModelProjector $projector,
        EventStore $eventStore
    ) {
        $this->projector = $projector;
        $this->eventStore = $eventStore;
    }

    public function __invoke(AggregateChangedEvent $event)
    {
        $streamName = $this->getStreamName($event);

        if (!$this->projectorInitialized) {
            $this->projector->fromStream($streamName);
            $this->projectorInitialized = true;
        }
        $this->projector->run(false);
    }

    private function getStreamName(AggregateChangedEvent $event): StreamName
    {
        $streamName = $event->getAggregateClass() . '-' . $event->aggregateId();

        $streamsNames = $this->eventStore->fetchStreamNames(
            $streamName,
            null
        );

        return $streamsNames[0];
    }
}
