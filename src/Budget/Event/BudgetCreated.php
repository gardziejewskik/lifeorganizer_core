<?php

namespace LifeOrganizer\Core\Budget\Event;

use Prooph\EventSourcing\AggregateChanged;

class BudgetCreated extends AggregateChanged
{
    public function id(): string
    {
        return $this->payload()['id'];
    }

    public function name(): string
    {
        return $this->payload()['name'];
    }
}
