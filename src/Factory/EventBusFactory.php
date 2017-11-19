<?php

namespace LifeOrganizer\Factory;

use LifeOrganizer\Core\Budget\Event\BudgetCreated;
use LifeOrganizer\Core\Budget\Event\NameChanged;
use Prooph\ServiceBus\EventBus;
use Prooph\ServiceBus\MessageBus;
use Prooph\ServiceBus\Plugin\Router\EventRouter;

class EventBusFactory
{
    public function create(): MessageBus
    {
        $eventBus = new EventBus(
            $this->container->get('prooph_action_event_emitter')
        );
        $budgetProjector = $this->container->get('budget_projector');
        $eventRouter = new EventRouter();

        $eventRouter->route(BudgetCreated::class)
            ->to([$budgetProjector, 'onBudgetCreated']);
        $eventRouter->route(NameChanged::class)
            ->to([$budgetProjector, 'onNameChanged']);

        $eventRouter->attachToMessageBus($eventBus);

        return $eventBus;
    }
}
