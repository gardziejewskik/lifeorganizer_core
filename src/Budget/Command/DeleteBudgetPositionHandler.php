<?php

namespace LifeOrganizer\Core\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;

class DeleteBudgetPositionHandler
{
    private $repository;

    public function __construct(BudgetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteBudgetPosition $command): void
    {
        $budget = $this->repository->getById($command->payload()['budgetId']);
        $positionDetails = PositionDetails::fromDeletePositionCommand($command);
        $budget->deletePosition($positionDetails);

        $this->repository->save($budget);
    }
}
