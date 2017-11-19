<?php

namespace LifeOrganizer\Core\Budget\Event;

use Prooph\EventSourcing\AggregateChanged;

class NameChanged extends AggregateChanged
{
    public function name(): string
    {
        return $this->payload()['name'];
    }
}
