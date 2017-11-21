<?php

use LifeOrganizer\Core\Budget\Event\BudgetCreated;
use LifeOrganizer\Core\Budget\Event\NameChanged;
use LifeOrganizer\Core\Budget\Event\PositionAdded;
use LifeOrganizer\Core\Budget\Projection\BudgetProjector;

return [
    'event-bus' => [
        BudgetCreated::class => [
            [ BudgetProjector::class, 'onBudgetCreated' ]
        ],
        NameChanged::class => [
            [ BudgetProjector::class, 'onNameChanged' ]
        ],
        PositionAdded::class => [
            [ BudgetProjector::class, 'onPositionAdded' ]
        ],
    ]
];
