<?php

namespace LifeOrganizer\Core\Budget\Model;

use LifeOrganizer\Core\Budget\Event\BudgetCreated;
use LifeOrganizer\Core\Budget\Event\NameChanged;
use LifeOrganizer\Core\Budget\Event\PositionAdded;
use LifeOrganizer\Core\Budget\Event\PositionDeleted;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;
use LifeOrganizer\Core\Category\Category;
use Money\Money;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

class Budget extends AggregateRoot
{
    private $id;
    private $userId;
    private $categoryId;
    private $name;
    private $positions = [];
    private $plannedValue;

    public static function createWithData(
        string $id,
        string $name,
        string $userId,
        Category $category,
        Money $plannedValue
    ): self {
        $budget = new self;
        $budget->recordThat(BudgetCreated::occur($id, [
            'id' => $id,
            'name' => $name,
            'userId' => $userId,
            'categoryId' => $category->id(),
            'plannedValue' => $plannedValue->getAmount()
        ]));

        return $budget;
    }

    public function newName(string $name): void
    {
        if ($this->name === $name) {
            return;
        }

        $this->recordThat(NameChanged::occur($this->id, [
            'name' => $name
        ]));
    }

    public function addPosition(PositionDetails $positionDetails): void
    {
        $this->recordThat(
            PositionAdded::occur(
                $this->id,
                $positionDetails->asArray()
            )
        );
    }

    public function deletePosition(PositionDetails $positionDetails): void
    {
        $this->recordThat(
            PositionDeleted::occur(
                $this->id,
                $positionDetails->asArray()
            )
        );
    }

    public function positions()
    {
        return $this->positions;
    }

    protected function aggregateId(): string
    {
        return $this->id;
    }

    public function id(): string
    {
        return $this->id;
    }

    /**
     * @param AggregateChanged $event
     * @throws UnsupportedEvent
     */
    protected function apply(AggregateChanged $event): void
    {
        switch (get_class($event)) {
            case BudgetCreated::class:
                /** @var BudgetCreated $event */
                $this->id = $event->id();
                $this->name = $event->name();
                $this->userId = $event->userId();
                $this->categoryId = $event->categoryId();
                $this->plannedValue = $event->plannedValue();
                break;
            case NameChanged::class:
                /** @var NameChanged $event */
                $this->name = $event->name();
                break;
            case PositionAdded::class:
                /** @var PositionAdded $event */
                $budgetPosition = new BudgetPosition(
                    $this->aggregateId(),
                    $event->positionValue(),
                    $event->positionName()
                );
                $this->positions[] = $budgetPosition;
                break;
            case PositionDeleted::class:
                /** @var PositionDeleted $event */
                $budgetPosition = new BudgetPosition(
                    $this->aggregateId(),
                    $event->positionValue(),
                    $event->positionName()
                );

                $keyPositionToDelete = array_search($budgetPosition, $this->positions);
                unset($this->positions[$keyPositionToDelete]);
                break;
            default:
                throw new UnsupportedEvent(get_class($event));
        }
    }
}
