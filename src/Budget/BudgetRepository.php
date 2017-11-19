<?php

namespace LifeOrganizer\Core\Budget;

use LifeOrganizer\Core\Budget\Model\Budget;

interface BudgetRepository
{
    public function getById(string $id): ?Budget;
    public function save(Budget $budget): void;
}
