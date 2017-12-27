<?php

namespace LifeOrganizer\Core\Budget\Query;

use React\Promise\Deferred;
use LifeOrganizer\Core\Budget\Projection\BudgetFinder;

class GetAllBudgetsHandler
{
    private $budgetFinder;

    public function __construct(BudgetFinder $budgetFinder)
    {
        $this->budgetFinder = $budgetFinder;
    }

    public function __invoke(GetAllBudgets $query, Deferred $deferred = null)
    {
        return $this->budgetFinder->getAll();
    }
}
