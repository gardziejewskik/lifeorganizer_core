<?php

use LifeOrganizer\Core\Budget\Command\AddBudgetPosition;
use LifeOrganizer\Core\Budget\Command\AddBudgetPositionHandler;
use LifeOrganizer\Core\Budget\Command\ChangeName;
use LifeOrganizer\Core\Budget\Command\ChangeNameHandler;
use LifeOrganizer\Core\Budget\Command\CreateBudget;
use LifeOrganizer\Core\Budget\Command\CreateBudgetHandler;

return [
    'command-bus' => [
        CreateBudget::class => CreateBudgetHandler::class,
        ChangeName::class => ChangeNameHandler::class,
        AddBudgetPosition::class => AddBudgetPositionHandler::class
    ]
];
