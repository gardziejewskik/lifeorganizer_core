<?php

use LifeOrganizer\Core\Budget\Event\BudgetCreated;
use LifeOrganizer\Core\Budget\Event\NameChanged;
use LifeOrganizer\Core\Budget\Event\PositionAdded;
use LifeOrganizer\Core\EventProjectorHandler;

return [
    'event-bus' => [
        BudgetCreated::class => [
            [ EventProjectorHandler::class ]
        ],
        NameChanged::class => [
            [ EventProjectorHandler::class ]
        ],
        PositionAdded::class => [
            [ EventProjectorHandler::class ]
        ],
    ]
];
