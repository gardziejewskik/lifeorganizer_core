<?php

namespace LifeOrganizer\Core\Budget\Query;

class GetBudgetById
{
    private $budgetId;

    public function __construct(string $budgetId)
    {
        $this->budgetId = $budgetId;
    }

    public function getBudgetId(): string
    {
        return $this->budgetId;
    }
}
