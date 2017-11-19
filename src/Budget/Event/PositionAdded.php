<?php

namespace LifeOrganizer\Core\Budget\Event;

use Prooph\EventSourcing\AggregateChanged;

class PositionAdded extends AggregateChanged
{
    public function positionName(): string
    {
        return $this->payload()['name'];
    }

    public function positionValue(): string
    {
        return $this->payload()['value'];
    }
}
