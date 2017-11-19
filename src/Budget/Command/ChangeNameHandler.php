<?php

namespace LifeOrganizer\Core\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;

class ChangeNameHandler
{
    private $repository;

    public function __construct(BudgetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ChangeName $changeName): void
    {
        $budget = $this->repository->getById($changeName->id());
        $budget->newName($changeName->name());
        $this->repository->save($budget);
    }
}
