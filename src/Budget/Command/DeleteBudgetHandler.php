<?php

namespace LifeOrganizer\Core\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;

class DeleteBudgetHandler
{
    private $repository;

    public function __construct(BudgetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteBudget $deleteBudget): void
    {
        $budget = $this->repository->getById($deleteBudget->budgetId());
        $budget->delete();

        $this->repository->save($budget);
    }
}
