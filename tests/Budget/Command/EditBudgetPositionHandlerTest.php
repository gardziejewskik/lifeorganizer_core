<?php

namespace Test\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;
use LifeOrganizer\Core\Budget\Command\AddBudgetPosition;
use LifeOrganizer\Core\Budget\Command\AddBudgetPositionHandler;
use LifeOrganizer\Core\Budget\Command\EditBudgetPosition;
use LifeOrganizer\Core\Budget\Command\EditBudgetPositionHandler;
use LifeOrganizer\Core\Budget\Model\Budget;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;
use LifeOrganizer\Core\Category\Category;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class EditBudgetPositionHandlerTest extends TestCase
{
    /**
     * @test
     * @throws
     */
    public function whenCommandWasHandledPositionWasAddedToBudget()
    {
        $budgetUuid = '6dc74fd3-42e5-4b9e-a5c1-0ef720136881';
        $commandAdd = new AddBudgetPosition(
            123,
            'PLN',
            $budgetUuid,
            'fancyName'
        );
        $commandEdit = new EditBudgetPosition([
            'budgetId' => $budgetUuid,
            'new' => [
                'name' => 'newName',
                'value' => 999,
                'currencyCode' => 'EUR'
            ],
            'old' => [
                'name' => 'fancyName',
                'value' => 123,
                'currencyCode' => 'PLN'
            ]
        ]);
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
        $handlerAdd = new AddBudgetPositionHandler($budgetRepositoryMock);
        $handlerEdit = new EditBudgetPositionHandler($budgetRepositoryMock);

        $handlerAdd($commandAdd);
        $handlerEdit($commandEdit);

        $positionDetails = new PositionDetails(
            $budgetUuid,
            new Money(999, new Currency('EUR')),
            'newName'
        );
        $this->assertEquals(
            0,
            array_search($positionDetails, $budget->positions())
        );
    }
}
