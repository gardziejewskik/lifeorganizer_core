<?php

namespace LifeOrganizer\Core\Budget\ValueObject;

use LifeOrganizer\Core\Budget\Command\AddBudgetPosition;
use Money\Money;

class PositionDetails
{
    /** @var  string */
    private $budgetId;

    /** @var  string */
    private $name;

    /** @var Money */
    private $value;

    public function __construct(
        string $budgetId,
        Money $value,
        string $name = ''
    ) {
        $this->budgetId = $budgetId;
        $this->value = $value;
        $this->name = $name;
    }

    public static function fromAddPositionCommand(
        AddBudgetPosition $command
    ): self {
        $instance = new self(
            $command->payload()['budgetId'],
            $command->payload()['value'],
            $command->payload()['name']
        );

        return $instance;
    }

    public function asArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value->getAmount(),
            'budgetId' => $this->budgetId
        ];
    }
}
