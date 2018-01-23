<?php

namespace LifeOrganizer\Core\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;

class EditBudgetPositionHandler
{
    private $repository;

    public function __construct(BudgetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(EditBudgetPosition $command): void
    {
        $budgetId = $command->payload()['budgetId'];
        $budget = $this->repository->getById($budgetId);
        $oldPositionData = new PositionDetails(
            $command->payload()['old']['name'],
            $command->payload()['old']['value'],
            $budgetId
        );
        $newPositionData = new PositionDetails(
            $command->payload()['new']['name'],
            $command->payload()['new']['value'],
            $budgetId
        );

        $budget->editPosition($oldPositionData, $newPositionData);

        $this->repository->save($budget);
    }
}
