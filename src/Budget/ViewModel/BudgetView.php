<?php

namespace LifeOrganizer\Core\Budget\ViewModel;

class BudgetView
{
    private $id;
    private $userId;
    private $name;
    private $positions = [];

    public function __construct(
        string $id,
        string $userId,
        string $name,
        array $positions
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->positions = $positions;
    }
}
