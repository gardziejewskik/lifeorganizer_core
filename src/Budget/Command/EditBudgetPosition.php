<?php

namespace LifeOrganizer\Core\Budget\Command;

use Money\Currency;
use Money\Money;
use Prooph\Common\Messaging\Command;

final class EditBudgetPosition extends Command
{
    private $payload;

    public function __construct(array $payload) {
        $this->init();
        $this->setPayload([
            'budgetId' => $payload['budgetId'],
            'new' => [
                'name' => empty($payload['new']['name']) ? '' : $payload['new']['name'],
                'value' => new Money(
                    $payload['new']['value'],
                    new Currency($payload['new']['currencyCode'])
                )
            ],
            'old' => [
                'name' => empty($payload['old']['name']) ? '' : $payload['old']['name'],
                'value' => new Money(
                    $payload['old']['value'],
                    new Currency($payload['old']['currencyCode'])
                )
            ]
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

    public function oldPosition(): array
    {
        return $this->payload()['old'];
    }

    public function newPosition(): array
    {
        return $this->payload()['new'];
    }
}
