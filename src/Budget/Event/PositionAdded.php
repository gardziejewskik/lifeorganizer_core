<?php

namespace LifeOrganizer\Core\Budget\Event;

use LifeOrganizer\Core\Budget\BudgetAggregateChanged;

class PositionAdded extends BudgetAggregateChanged
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
