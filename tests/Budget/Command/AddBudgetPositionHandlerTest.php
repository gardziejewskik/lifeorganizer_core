<?php

namespace Test\Budget\Command;

use LifeOrganizer\Core\Budget\Command\AddBudgetPosition;
use LifeOrganizer\Core\Budget\Command\AddBudgetPositionHandler;
use LifeOrganizer\Core\Budget\InMemoryBudgetRepository;
use LifeOrganizer\Core\Budget\Model\Budget;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;
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
        $budget = $this->getMockBuilder(Budget::class)
            ->disableOriginalConstructor()
            ->getMock();
        $budget
            ->expects($this->once())
            ->method('addPosition')
            ->with(
                new PositionDetails(
                    '6dc74fd3-42e5-4b9e-a5c1-0ef720136881',
                    new Money(123, new Currency('PLN')),
                    'fancyName'
                )
            );
        $budget->method('id')->willReturn($budgetUuid);
        $budget->method('deleted')->willReturn(false);
        $budgetRepository = new InMemoryBudgetRepository([$budget]);
        $handler = new AddBudgetPositionHandler($budgetRepository);

        $handler($command);
    }
}
