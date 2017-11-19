<?php

namespace LifeOrganizer\Core\Budget\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

class ChangeName extends Command
{
    use PayloadTrait;

    public function id(): string
    {
        return $this->payload()['id'];
    }

    public function name(): string
    {
        return $this->payload()['name'];
    }
}
