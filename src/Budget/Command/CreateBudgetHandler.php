<?php

namespace LifeOrganizer\Core\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;
use LifeOrganizer\Core\Budget\Model\Budget;
use LifeOrganizer\Core\Budget\Model\CategoryDoesNotExist;
use LifeOrganizer\Core\Category\CategoryRepository;

class CreateBudgetHandler
{
    private $budgetRepository;
    private $categoryRepository;

    public function __construct(
        BudgetRepository $budgetRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->budgetRepository = $budgetRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param CreateBudget $command
     * @throws CategoryDoesNotExist
     */
    public function __invoke(CreateBudget $command): void
    {
        $this->checkCategory($command->category()->id());

        $budget = Budget::createWithData(
            $command->id(),
            $command->name(),
            $command->userId(),
            $command->category(),
            $command->plannedValue()
        );

        $this->budgetRepository->save($budget);
    }

    /**
     * @param string $categoryId
     * @throws CategoryDoesNotExist
     */
    private function checkCategory(string $categoryId): void
    {
        if (!$this->categoryRepository->exist($categoryId))
            throw new CategoryDoesNotExist();
    }
}
