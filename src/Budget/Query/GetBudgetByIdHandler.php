<?php

namespace LifeOrganizer\Core\Budget\Query;

use LifeOrganizer\Core\Budget\Projection\BudgetFinder;

class GetBudgetByIdHandler
{
    private $budgetFinder;

    public function __construct(BudgetFinder $budgetFinder)
    {
        $this->budgetFinder = $budgetFinder;
    }
    
    public function __invoke(GetBudgetById $query)
    {
        return $this->budgetFinder->getById($query->getBudgetId());
    }
}
