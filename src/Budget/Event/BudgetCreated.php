<?php

namespace LifeOrganizer\Core\Budget\Event;

use LifeOrganizer\Core\Budget\BudgetAggregateChanged;
use LifeOrganizer\Core\Category\Category;

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

    public function category(): Category
    {
        return $this->payload()['category'];
    }
}
