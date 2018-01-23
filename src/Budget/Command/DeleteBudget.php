<?php

namespace LifeOrganizer\Core\Budget\Command;

use Prooph\Common\Messaging\Command;

class DeleteBudget extends Command
{
    private $payload;

    public function __construct(string $budgetId)
    {
        $this->payload = [
            'budgetId' => $budgetId
        ];
    }

    public function budgetId(): string
    {
        return $this->payload()['budgetId'];
    }

    public function payload(): array
    {
        return $this->payload;
    }

    protected function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }
}
