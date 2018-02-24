<?php

namespace LifeOrganizer\Core\Budget\ReadModel;

use Prooph\EventStore\Projection\ReadModel;

interface BudgetReadModel extends ReadModel
{
    public function insert(array $data): void;

    public function update(string $id, array $data): void;

    public function budgetDeleted(string $id): void;

    public function positionAdded(array $data): void;

    public function positionEdited(array $data): void;

    public function positionDeleted(array $data): void;
}
