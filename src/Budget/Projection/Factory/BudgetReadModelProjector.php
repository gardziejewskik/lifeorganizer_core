<?php

namespace LifeOrganizer\Core\Budget\Projection\Factory;

use LifeOrganizer\Core\Budget\Event\BudgetCreated;
use LifeOrganizer\Core\Budget\Event\NameChanged;
use LifeOrganizer\Core\Budget\Event\PositionAdded;
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
                    ]
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
            }
        ]);

        return $projector;
    }

    private function readModel(): ReadModel
    {
        return $this->readModel;
    }
}
