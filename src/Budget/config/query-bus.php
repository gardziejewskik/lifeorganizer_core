<?php

use LifeOrganizer\Core\Budget\Query\GetAllBudgets;
use LifeOrganizer\Core\Budget\Query\GetAllBudgetsHandler;
use LifeOrganizer\Core\Budget\Query\GetBudgetById;
use LifeOrganizer\Core\Budget\Query\GetBudgetByIdHandler;

return [
    'query-bus' => [
        GetAllBudgets::class => GetAllBudgetsHandler::class,
        GetBudgetById::class => GetBudgetByIdHandler::class,
    ]
];
