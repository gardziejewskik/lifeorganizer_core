<?php

namespace LifeOrganizer\Core\Budget\Query;

use LifeOrganizer\Core\Budget\Projection\BudgetFinder;

class GetAllBudgetsHandler
{
    private $budgetFinder;

    public function __construct(BudgetFinder $budgetFinder)
    {
        $this->budgetFinder = $budgetFinder;
    }

    public function __invoke(GetAllBudgets $query)
    {
        return $this->budgetFinder->getAll();
    }
}
