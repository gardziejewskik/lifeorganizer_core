<?php

namespace LifeOrganizer\Core\Budget;

use LifeOrganizer\Core\Budget\Exception\BudgetDoesNotExist;
use LifeOrganizer\Core\Budget\Model\Budget;

interface BudgetRepository
{
    /**
     * @param string $id
     * @param array $options
     * @return Budget
     *
     * @throws BudgetDoesNotExist
     */
    public function getById(
        string $id,
        array $options = [ 'deleted' => false ]
    ): Budget;

    public function save(Budget $budget): void;
}
