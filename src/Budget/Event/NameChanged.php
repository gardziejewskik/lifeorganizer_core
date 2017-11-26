<?php

namespace LifeOrganizer\Core\Budget\Event;

use LifeOrganizer\Core\Budget\BudgetAggregateChanged;

class NameChanged extends BudgetAggregateChanged
{
    public function name(): string
    {
        return $this->payload()['name'];
    }
}
