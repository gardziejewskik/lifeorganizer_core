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
            $budgetId,
            $command->payload()['old']['value'],
            $command->payload()['old']['name']
        );
        $newPositionData = new PositionDetails(
            $budgetId,
            $command->payload()['new']['value'],
            $command->payload()['new']['name']
        );

        $budget->editPosition($oldPositionData, $newPositionData);

        $this->repository->save($budget);
    }
}
