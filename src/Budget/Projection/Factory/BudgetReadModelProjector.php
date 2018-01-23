<?php

namespace LifeOrganizer\Core\Budget\Projection\Factory;

use LifeOrganizer\Core\Budget\Event\BudgetCreated;
use LifeOrganizer\Core\Budget\Event\BudgetDeleted;
use LifeOrganizer\Core\Budget\Event\NameChanged;
use LifeOrganizer\Core\Budget\Event\PositionAdded;
use LifeOrganizer\Core\Budget\Event\PositionDeleted;
use LifeOrganizer\Core\Budget\Event\PositionEdited;
use LifeOrganizer\Core\Budget\ReadModel\BudgetReadModel;
use Prooph\EventStore\Projection\ProjectionManager;
use Prooph\EventStore\Projection\ReadModel;
use Prooph\EventStore\Projection\ReadModelProjector;

class BudgetReadModelProjector
{
    private $readModel;

    private $projectionManager;

    public function __construct(
        ProjectionManager $projectionManager,
        BudgetReadModel $readModel
    ) {
        $this->projectionManager = $projectionManager;
        $this->readModel = $readModel;
    }

    public function factory(): ReadModelProjector
    {
        $projector = $this->projectionManager->createReadModelProjection(
            'read_model_budget',
            $this->readModel(),
            []
        );
        $projector->when([
            BudgetCreated::class => function ($state, BudgetCreated $event) {
                $readModel = $this->readModel();
                $readModel->stack('insert',
                    [
                        'id' => $event->id(),
                        'name' => $event->name(),
                        'userId' => $event->userId(),
                        'categoryId' => $event->categoryId(),
                        'plannedValue' => $event->plannedValue(),
                    ]
                );
            },
            BudgetDeleted::class => function ($state, BudgetDeleted $event) {
                $readModel = $this->readModel();
                $readModel->stack(
                    'budgetDeleted',
                    $event->aggregateId()
                );
            },
            NameChanged::class => function ($state, NameChanged $event) {
                $readModel = $this->readModel();
                $readModel->stack(
                    'update',
                    [
                        'name' => $event->name()
                    ]
                );
            },
            PositionAdded::class => function ($state, PositionAdded $event) {
                $readModel = $this->readModel();
                $readModel->stack(
                    'positionAdded',
                    [
                        'budgetId' => $event->aggregateId(),
                        'name' => $event->positionName(),
                        'positionValue' => $event->positionValue()
                    ]
                );
            },
            PositionEdited::class => function ($state, PositionEdited $event) {
                $readModel = $this->readModel();
                $readModel->stack(
                    'positionEdited',
                    [
                        'budgetId' => $event->aggregateId(),
                        'old' => [
                            'value' => $event->oldPositionValue(),
                            'name' => $event->oldPositionName()
                        ],
                        'new' => [
                            'value' => $event->newPositionValue(),
                            'name' => $event->newPositionName()
                        ]
                    ]
                );
            },
            PositionDeleted::class => function ($state, PositionDeleted $event) {
                $readModel = $this->readModel();
                $readModel->stack(
                    'positionDeleted',
                    [
                        'budgetId' => $event->aggregateId(),
                        'name' => $event->positionName(),
                        'positionValue' => $event->positionValue()
                    ]
                );
            }
        ]);

        return $projector;
    }

    private function readModel(): ReadModel
    {
        return $this->readModel;
    }
}
