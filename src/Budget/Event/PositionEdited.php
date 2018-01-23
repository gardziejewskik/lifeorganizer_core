<?php

namespace LifeOrganizer\Core\Budget\Event;

use LifeOrganizer\Core\Budget\BudgetAggregateChanged;

class PositionEdited extends BudgetAggregateChanged
{
    public function oldPositionName(): string
    {
        return $this->payload()['old']['name'];
    }

    public function oldPositionValue(): string
    {
        return $this->payload()['old']['value'];
    }

    public function newPositionName(): string
    {
        return $this->payload()['new']['name'];
    }

    public function newPositionValue(): string
    {
        return $this->payload()['new']['value'];
    }
}
