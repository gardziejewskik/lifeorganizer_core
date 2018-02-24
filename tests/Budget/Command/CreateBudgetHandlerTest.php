<?php

namespace Test\Budget\Command;

use LifeOrganizer\Core\Budget\BudgetRepository;
use LifeOrganizer\Core\Budget\Command\CreateBudget;
use LifeOrganizer\Core\Budget\Command\CreateBudgetHandler;
use LifeOrganizer\Core\Budget\InMemoryBudgetRepository;
use LifeOrganizer\Core\Category\Category;
use LifeOrganizer\Core\Category\CategoryRepository;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateBudgetHandlerTest extends TestCase
{
    /**
     * @test
     * @throws
     */
    public function whenCommandWasHandledBudgetIsCreatedAndSavedInRepository()
    {
        $uuid = '6dc74fd3-42e5-4b9e-a5c1-0ef720136881';
        $command = new CreateBudget([
            'id' => Uuid::fromString($uuid),
            'name' => 'testBudget',
            'category' => new Category('1', '1'),
            'userId' => '1',
            'plannedValue' => new Money(123, new Currency('PLN'))
        ]);

        $budgetRepository = new InMemoryBudgetRepository();

        $categoryRepositoryMock = $this->createMock(
            CategoryRepository::class
        );
        $categoryRepositoryMock->method('exist')
            ->with('1')
            ->willReturn(true);

        /** @var BudgetRepository $budgetRepositoryMock */
        /** @var CategoryRepository $categoryRepositoryMock */
        $handler = new CreateBudgetHandler(
            $budgetRepository,
            $categoryRepositoryMock
        );

        $handler($command);

        $this->assertCount(1, $budgetRepository);
    }
}
