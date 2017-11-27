<?php

namespace LifeOrganizer\Core\Budget\Projection;

use stdClass;

interface BudgetFinder
{
    public function getById(string $id): stdClass;
    public function getAll(): array;
}
