<?php

namespace LifeOrganizer\Core\Budget\Query;

use LifeOrganizer\Core\Budget\ViewModel\BudgetView;

interface BudgetQuery
{
    public function get(string $id): BudgetView;
    public function getWithPositions(string $id): BudgetView;

    /**
     * @param string $userId
     * @return BudgetView[]
     */
    public function getAllForUser(string $userId): array;
}
