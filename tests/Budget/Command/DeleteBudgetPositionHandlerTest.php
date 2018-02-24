<?php

namespace Test\Budget\Command;

use LifeOrganizer\Core\Budget\Command\DeleteBudgetPosition;
use LifeOrganizer\Core\Budget\Command\DeleteBudgetPositionHandler;
use LifeOrganizer\Core\Budget\InMemoryBudgetRepository;
use LifeOrganizer\Core\Budget\Model\Budget;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;
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
        $deleteCommand = new DeleteBudgetPosition(
            123,
            'PLN',
            $budgetUuid,
            'fancyName'
        );
        $budget = $this->getMockBuilder(Budget::class)
            ->disableOriginalConstructor()
            ->getMock();
        $budget->method('id')->willReturn($budgetUuid);
        $budget->method('deleted')->willReturn(false);
        $budget->expects($this->once())
            ->method('deletePosition')
            ->with(
                new PositionDetails(
                    $budgetUuid,
                    new Money(123, new Currency('PLN')),
                    'fancyName'
                )
            );
        $budgetRepository = new InMemoryBudgetRepository([$budget]);
        $deleteHandler = new DeleteBudgetPositionHandler($budgetRepository);

        $deleteHandler($deleteCommand);
    }
}
