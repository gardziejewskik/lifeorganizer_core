<?php

namespace LifeOrganizer\Core\Budget\Command;

use DateTime;
use LifeOrganizer\Core\Category\Category;
use Money\Money;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

class CreateBudget extends Command
{
    use PayloadTrait;

    public function name(): string
    {
        return $this->payload()['name'];
    }

    public function id(): string
    {
        return $this->payload()['id'];
    }

    public function userId(): string
    {
        return $this->payload()['userId'];
    }

    public function value(): Money
    {
        return $this->payload()['value'];
    }

    public function plannedValue(): Money
    {
        return $this->payload()['plannedValue'];
    }

    public function amount(): int
    {
        return $this->payload()['amount'];
    }

    public function measureUnitId(): string
    {
        return $this->payload()['measureUnitId'];
    }

    public function category(): Category
    {
        return $this->payload()['category'];
    }

    public function beginOfUsage(): DateTime
    {
        return $this->payload()['beginOfUsage'];
    }

    public function endOfUsage(): DateTime
    {
        return $this->payload()['endOfUsage'];
    }
}
