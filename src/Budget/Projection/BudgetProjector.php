<?php

namespace LifeOrganizer\Core\Budget\Projection;

use LifeOrganizer\Core\Budget\Event\BudgetCreated;
use LifeOrganizer\Core\Budget\Event\NameChanged;

class BudgetProjector
{
    public function onBudgetCreated(BudgetCreated $event): void
    {
    }

    public function onNameChanged(NameChanged $event): void
    {
    }
}
