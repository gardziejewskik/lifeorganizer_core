<?php

namespace LifeOrganizer\Core\Budget\Event;

use LifeOrganizer\Core\Budget\BudgetAggregateChanged;

class BudgetCreated extends BudgetAggregateChanged
{
    public function id(): string
    {
        return $this->payload()['id'];
    }

    public function userId(): string
    {
        return $this->payload()['userId'];
    }

    public function name(): string
    {
        return $this->payload()['name'];
    }

    public function plannedValue(): string
    {
        return $this->payload()['plannedValue'];
    }

    public function categoryId(): string
    {
        return $this->payload()['categoryId'];
    }
}
