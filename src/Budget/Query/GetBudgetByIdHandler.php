<?php

namespace LifeOrganizer\Core\Budget\Query;

use React\Promise\Deferred;
use LifeOrganizer\Core\Budget\Projection\BudgetFinder;

class GetBudgetByIdHandler
{
    private $budgetFinder;

    public function __construct(BudgetFinder $budgetFinder)
    {
        $this->budgetFinder = $budgetFinder;
    }

    public function __invoke(GetBudgetById $query, Deferred $deferred = null)
    {
        $budget = $this->budgetFinder->getById($query->getBudgetId());
        if (is_null($deferred)) {
            return $budget;
        }

        $deferred->resolve($budget);
    }
}
