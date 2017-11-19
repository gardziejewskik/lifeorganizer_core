<?php

namespace LifeOrganizer\Core\Budget\Command;

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
}
