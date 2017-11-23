<?php

namespace LifeOrganizer\Core\Budget\Query;

use LifeOrganizer\Core\Budget\ViewModel\BudgetPositionView;

interface BudgetPositionQuery
{
    public function get(string $id): BudgetPositionView;

    /**
     * @param string $budgetId
     * @return array
     */
    public function getAllForBudget(string $budgetId): array;
}
