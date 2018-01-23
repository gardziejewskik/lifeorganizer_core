<?php

namespace LifeOrganizer\Core\Budget\Event;

use LifeOrganizer\Core\Budget\BudgetAggregateChanged;

class BudgetDeleted extends BudgetAggregateChanged
{
    public function id(): string
    {
        return $this->payload()['id'];
    }
}
