<?php

namespace LifeOrganizer\Core\Budget;

use LifeOrganizer\Core\AggregateChangedEvent;
use LifeOrganizer\Core\Budget\Model\Budget;
use Prooph\EventSourcing\AggregateChanged;

abstract class BudgetAggregateChanged
    extends AggregateChanged
    implements AggregateChangedEvent
{
    public function getAggregateClass(): string
    {
        return Budget::class;
    }
}
