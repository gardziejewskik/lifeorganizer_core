<?php

namespace Test\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;
use LifeOrganizer\Core\Budget\Command\AddBudgetPosition;
use LifeOrganizer\Core\Budget\Command\AddBudgetPositionHandler;
use LifeOrganizer\Core\Budget\Model\Budget;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;
use LifeOrganizer\Core\Category\Category;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class AddBudgetPositionHandlerTest extends TestCase
{
    /**
     * @test
     * @throws
     */
    public function whenCommandWasHandledPositionWasAddedToBudget()
    {
        $budgetUuid = '6dc74fd3-42e5-4b9e-a5c1-0ef720136881';
        $command = new AddBudgetPosition(
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
        $handler = new AddBudgetPositionHandler($budgetRepositoryMock);

        $handler($command);

        $positionDetails = new PositionDetails(
            $budgetUuid,
            new Money(123, new Currency('PLN')),
            'fancyName'
        );
        $this->assertEquals(
            0,
            array_search($positionDetails, $budget->positions())
        );
    }
}
