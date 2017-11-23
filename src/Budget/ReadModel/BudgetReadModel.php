<?php

namespace LifeOrganizer\Core\Budget\ReadModel;

use Prooph\EventStore\Projection\ReadModel;

interface BudgetReadModel extends ReadModel
{
    public function insert(array $data): void;
    public function update(array $data): void;
    public function positionAdded(array $data): void;
}
