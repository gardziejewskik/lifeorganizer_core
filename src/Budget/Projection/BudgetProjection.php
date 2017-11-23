<?php

namespace LifeOrganizer\Core\Budget\Projection;

use LifeOrganizer\Core\Budget\Event\BudgetCreated;
use LifeOrganizer\Core\Budget\Event\NameChanged;
use LifeOrganizer\Core\Budget\Event\PositionAdded;
use LifeOrganizer\Core\Budget\ReadModel\BudgetReadModel;
use Prooph\EventStore\Projection\ReadModel;
use Prooph\EventStore\Projection\ReadModelProjector;

class BudgetProjection
{
    private $readModel;

    public function __construct(BudgetReadModel $readModel)
    {
        $this->readModel = $readModel;
    }

    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStream('event_stream')
            ->when([
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