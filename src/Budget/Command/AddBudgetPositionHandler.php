<?php

namespace LifeOrganizer\Core\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;

class AddBudgetPositionHandler
{
    private $repository;

    public function __construct(BudgetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddBudgetPosition $command): void
    {
        $budget = $this->repository->getById($command->payload()['budgetId']);
        $positionDetails = PositionDetails::fromAddPositionCommand($command);
        $budget->addPosition($positionDetails);

        $this->repository->save($budget);
    }
}
