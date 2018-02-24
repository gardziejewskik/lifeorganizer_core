<?php

namespace Test\Budget\Command;

use LifeOrganizer\Core\Budget\Command\DeleteBudget;
use LifeOrganizer\Core\Budget\Command\DeleteBudgetHandler;
use LifeOrganizer\Core\Budget\InMemoryBudgetRepository;
use LifeOrganizer\Core\Budget\Model\Budget;
use LifeOrganizer\Core\Category\Category;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class DeleteBudgetHandlerTest extends TestCase
{
    /**
     * @test
     * @throws
     */
    public function whenCommandWasHandledPositionWasAddedToBudget()
    {
        $budgetUuid = '6dc74fd3-42e5-4b9e-a5c1-0ef720136881';
        $budget = Budget::createWithData(
            $budgetUuid,
            'testBudget',
            'someId',
            new Category('1', '1'),
            new Money(123, new Currency('PLN'))
        );
        $budgetRepository = new InMemoryBudgetRepository([$budget]);
        $command = new DeleteBudget($budgetUuid);
        $handler = new DeleteBudgetHandler($budgetRepository);

        $handler($command);

        $this->assertTrue($budget->deleted());
    }
}
