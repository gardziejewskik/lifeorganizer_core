<?php

namespace Test\Budget\Command;

use LifeOrganizer\Core\Budget\Command\EditBudgetPosition;
use LifeOrganizer\Core\Budget\Command\EditBudgetPositionHandler;
use LifeOrganizer\Core\Budget\InMemoryBudgetRepository;
use LifeOrganizer\Core\Budget\Model\Budget;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class EditBudgetPositionHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function whenCommandWasHandledPositionWasAddedToBudget()
    {
        $budgetUuid = '6dc74fd3-42e5-4b9e-a5c1-0ef720136881';
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
        $budget = $this->getMockBuilder(Budget::class)
            ->disableOriginalConstructor()
            ->getMock();
        $budget->method('id')->willReturn($budgetUuid);
        $budget->method('deleted')->willReturn(false);
        $budget->expects($this->once())
            ->method('editPosition')
            ->with(
                new PositionDetails(
                    $budgetUuid,
                    new Money(123, new Currency('PLN')),
                    'fancyName'
                ),
                new PositionDetails(
                    $budgetUuid,
                    new Money(999, new Currency('EUR')),
                    'newName'
                )
            );
        $budgetRepository = new InMemoryBudgetRepository([$budget]);
        $handlerEdit = new EditBudgetPositionHandler($budgetRepository);

        $handlerEdit($commandEdit);
    }
}
