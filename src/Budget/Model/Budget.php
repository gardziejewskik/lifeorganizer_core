<?php

namespace LifeOrganizer\Core\Budget\Model;

use LifeOrganizer\Core\Budget\Event\BudgetCreated;
use LifeOrganizer\Core\Budget\Event\BudgetDeleted;
use LifeOrganizer\Core\Budget\Event\NameChanged;
use LifeOrganizer\Core\Budget\Event\PositionAdded;
use LifeOrganizer\Core\Budget\Event\PositionDeleted;
use LifeOrganizer\Core\Budget\Event\PositionEdited;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;
use LifeOrganizer\Core\Category\Category;
use Money\Currency;
use Money\Money;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

class Budget extends AggregateRoot
{
    private $id;
    private $userId;
    private $categoryId;
    private $name;

    /**
     * @var BudgetPosition[]
     */
    private $positions = [];

    private $plannedValue;
    private $deleted = false;

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

    public function hasCategory(Category $category): bool
    {
        return $this->categoryId === $category->id();
    }

    public function planned(): string
    {
        return $this->plannedValue;
    }

    public function value(): Money
    {
        $value = new Money(0, new Currency('PLN'));
        foreach ($this->positions() as $position) {
            /** @var BudgetPosition $position */
            $value = $value->add(new Money($position->value(), new Currency('PLN')));
        }

        return $value;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function delete()
    {
        $this->recordThat(
            BudgetDeleted::occur(
                $this->id,
                [ 'budgetId' => $this->id ]
            )
        );
    }

    public function deleted(): bool
    {
        return $this->deleted;
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

    public function editPosition(
        PositionDetails $oldPositionDetails,
        PositionDetails $newPositionDetails
    ): void {
        $this->recordThat(
            PositionEdited::occur(
                $this->id,
                [
                    'old' => $oldPositionDetails->asArray(),
                    'new' => $newPositionDetails->asArray(),
                ]
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

    public function id(): string
    {
        return $this->id;
    }

    protected function aggregateId(): string
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
            case BudgetDeleted::class:
                $this->deleted = true;
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
            case PositionEdited::class:
                /** @var PositionEdited $event */
                $oldBudgetPosition = new BudgetPosition(
                    $this->aggregateId(),
                    $event->oldPositionValue(),
                    $event->oldPositionName()
                );

                $newBudgetPosition = new BudgetPosition(
                    $this->aggregateId(),
                    $event->newPositionValue(),
                    $event->newPositionName()
                );

                $keyPositionToEdit = array_search($oldBudgetPosition, $this->positions);
                $this->positions[$keyPositionToEdit] = $newBudgetPosition;
                break;
            default:
                throw new UnsupportedEvent(get_class($event));
        }
    }

    private function positions()
    {
        foreach ($this->positions as $position) {
            yield $position;
        }
    }
}
