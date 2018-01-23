<?php

namespace Test\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;
use LifeOrganizer\Core\Budget\Command\DeleteBudget;
use LifeOrganizer\Core\Budget\Command\DeleteBudgetHandler;
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

        $budgetRepositoryMock = $this->createMock(
            BudgetRepository::class
        );
        $budgetRepositoryMock->method('getById')
            ->willReturn($budget);

        $command = new DeleteBudget($budgetUuid);
        /** @var BudgetRepository $budgetRepositoryMock */
        $handler = new DeleteBudgetHandler($budgetRepositoryMock);

        $handler($command);

        $this->assertTrue($budget->deleted());
    }
}
