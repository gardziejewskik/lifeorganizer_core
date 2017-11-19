<?php

namespace LifeOrganizer\Factory;

use LifeOrganizer\Core\Budget\Command\AddBudgetPosition;
use LifeOrganizer\Core\Budget\Command\ChangeName;
use LifeOrganizer\Core\Budget\Command\CreateBudget;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\MessageBus;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;

class CommandBusFactory
{
    public function create(): MessageBus
    {
        $commandBus = new CommandBus();
        $router = new CommandRouter();

//        $router->route(CreateBudget::class)
//            ->to(
//                $this->container->get(
//                    'budget.command.handler.create_budget'
//                )
//            );
//        $router->route(ChangeName::class)
//            ->to(
//                $this->container->get(
//                    'budget.command.handler.change_name'
//                )
//            );
//        $router->route(AddBudgetPosition::class)
//            ->to(
//                $this->container->get(
//                    'budget.command.handler.add_budget_position'
//                )
//            );

        $router->attachToMessageBus($commandBus);

        return $commandBus;
    }
}
