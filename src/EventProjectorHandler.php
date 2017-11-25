<?php

namespace LifeOrganizer\Core;

use LifeOrganizer\Core\Budget\Model\Budget;
use Prooph\Common\Messaging\Message;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Projection\ReadModelProjector;
use Prooph\EventStore\StreamName;

class EventProjectorHandler
{
    /**
     * @var ReadModelProjector
     */
    private $projector;
    /**
     * @var EventStore
     */
    private $eventStore;

    public function __construct(
        ReadModelProjector $projector,
        EventStore $eventStore
    ) {
        $this->projector = $projector;
        $this->eventStore = $eventStore;
    }

    public function __invoke(AggregateChanged $event)
    {
        $streams = $this->eventStore->fetchStreamNames(
            Budget::class . '-' . $event->aggregateId(),
            null
        );

        /** @var StreamName $stream */
        $stream = $streams[0];

        $this->projector->fromStream($stream);
        $this->projector->run(false);
    }
}
