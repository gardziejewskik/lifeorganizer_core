<?php

namespace LifeOrganizer\Core\Budget\Model;

class BudgetPosition
{
    private $budgetId;
    private $value;
    private $name;

    public function __construct(string $budgetId, string $value, string $name)
    {
        $this->budgetId = $budgetId;
        $this->value = $value;
        $this->name = $name;
    }

    public function value(): string
    {
        return $this->value;
    }
}
