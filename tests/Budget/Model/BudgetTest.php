<?php

namespace tests\Budget\Model;

use LifeOrganizer\Core\Budget\Event\BudgetCreated;
use LifeOrganizer\Core\Budget\Event\NameChanged;
use LifeOrganizer\Core\Budget\Event\PositionAdded;
use LifeOrganizer\Core\Budget\Model\Budget;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Prooph\EventSourcing\EventStoreIntegration\AggregateRootDecorator;

class BudgetTest extends TestCase
{
    /**
     * @test
     */
    public function whenBudgetIsCreatedThenBudgetCreatedEventIsApplied()
    {
        $budgetName = "name";
        $budgetId = "id";
        $userId = "userId";

        $budget = Budget::createWithData($budgetId, $budgetName, $userId);

        $decorator = AggregateRootDecorator::newInstance();
        $recordedEvents = $decorator->extractRecordedEvents($budget);
        $event = $recordedEvents[0];
        $this->assertInstanceOf(BudgetCreated::class, $event);
        $this->assertEquals($budgetName, $event->payload()['name']);
        $this->assertEquals($budgetId, $event->payload()['id']);
        $this->assertEquals($userId, $event->payload()['userId']);
    }

    /**
     * @test
     */
    public function whenBudgetNameIsChangedThenBudgetNameChangedEventIsApplied()
    {
        $budget = $this->createBudget();
        $budgetNewName = "newName";

        $budget->newName($budgetNewName);

        $decorator = AggregateRootDecorator::newInstance();
        $recordedEvents = $decorator->extractRecordedEvents($budget);
        $event = $recordedEvents[1];
        $this->assertInstanceOf(NameChanged::class, $event);
    }

    /**
     * @test
     */
    public function whenBudgetPositionIsAddedThenBudgetPositionAddedEventIsApplied()
    {
        $budget = $this->createBudget();
        $positionDetails = new PositionDetails(
            'id',
            new Money(123, new Currency('PLN')),
            'zakupy'
        );

        $budget->addPosition($positionDetails);

        $decorator = AggregateRootDecorator::newInstance();
        $recordedEvents = $decorator->extractRecordedEvents($budget);
        $event = $recordedEvents[1];
        $this->assertInstanceOf(PositionAdded::class, $event);
        $this->assertArrayHasKey('budgetId', $event->payload());
        $this->assertEquals('id', $event->payload()['budgetId']);
        $this->assertArrayHasKey('value', $event->payload());
        $this->assertEquals('123', $event->payload()['value']);
        $this->assertArrayHasKey('name', $event->payload());
        $this->assertEquals('zakupy', $event->payload()['name']);
    }

    private function createBudget(): Budget
    {
        return Budget::createWithData('id', 'name', 'userId');
    }
}
