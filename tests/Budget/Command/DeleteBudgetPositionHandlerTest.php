<?php

namespace Test\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;
use LifeOrganizer\Core\Budget\Command\AddBudgetPosition;
use LifeOrganizer\Core\Budget\Command\AddBudgetPositionHandler;
use LifeOrganizer\Core\Budget\Command\DeleteBudgetPosition;
use LifeOrganizer\Core\Budget\Command\DeleteBudgetPositionHandler;
use LifeOrganizer\Core\Budget\Model\Budget;
use LifeOrganizer\Core\Category\Category;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class DeleteBudgetPositionHandlerTest extends TestCase
{
    /**
     * @test
     * @throws
     */
    public function whenCommandWasHandledPositionWasAddedToBudget()
    {
        $budgetUuid = '6dc74fd3-42e5-4b9e-a5c1-0ef720136881';
        $addCommand = new AddBudgetPosition(
            123,
            'PLN',
            $budgetUuid,
            'fancyName'
        );
        $deleteCommand = new DeleteBudgetPosition(
            123,
            'PLN',
            $budgetUuid,
            'fancyName'
        );
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

        /** @var BudgetRepository $budgetRepositoryMock */
        $addHandler = new AddBudgetPositionHandler($budgetRepositoryMock);
        $deleteHandler = new DeleteBudgetPositionHandler($budgetRepositoryMock);

        $addHandler($addCommand);
        $deleteHandler($deleteCommand);

        $this->assertEquals(0, count($budget->positions()));
    }
}
