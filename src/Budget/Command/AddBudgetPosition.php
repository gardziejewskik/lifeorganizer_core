<?php

namespace LifeOrganizer\Core\Budget\Command;

use Money\Currency;
use Money\Money;
use Prooph\Common\Messaging\Command;

final class AddBudgetPosition extends Command
{
    private $payload;

    public function __construct(
        string $value,
        string $currencyCode,
        string $budgetId,
        string $name = null
    ) {
        $value = new Money($value, new Currency($currencyCode));

        $this->init();
        $this->setPayload([
            'name' => empty($name) ? '' : $name,
            'value' => $value,
            'budgetId' => $budgetId
        ]);
    }

    protected function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    public function payload(): array
    {
        return $this->payload;
    }
}
