<?php

namespace LifeOrganizer\Core\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;
use LifeOrganizer\Core\Budget\Model\Budget;

class CreateBudgetHandler
{
    private $repository;

    public function __construct(BudgetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateBudget $command): void
    {
        $budget = Budget::createWithData($command->id(), $command->name());

        $this->repository->save($budget);
    }
}
