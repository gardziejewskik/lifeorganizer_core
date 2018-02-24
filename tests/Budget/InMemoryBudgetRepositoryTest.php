<?php declare(strict_types=1);

namespace Test\Budget;

use LifeOrganizer\Core\Budget\Exception\BudgetDoesNotExist;
use LifeOrganizer\Core\Budget\Exception\UnexpectedDuplicates;
use LifeOrganizer\Core\Budget\InMemoryBudgetRepository;
use LifeOrganizer\Core\Budget\Model\Budget;
use LifeOrganizer\Core\Category\Category;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class InMemoryBudgetRepositoryTest extends TestCase
{

    /**
     * @var InMemoryBudgetRepository $inMemoryBudgetRepository
     */
    private $inMemoryBudgetRepository;

    public function setUp(): void
    {
        $properBudget = Budget::createWithData(
            'bc912b21-8b0b-4635-82df-f74a09fd69e1',
            'name',
            'c8090c8b-5dca-4335-a1aa-3c18214eed62',
            new Category('1', '1'),
            new Money(123, new Currency('PLN'))
        );

        $deletedBudget = Budget::createWithData(
            'bc912b21-8b0b-4635-82df-f74a09fd68i0',
            'name',
            'c8090c8b-5dca-4335-a1aa-3c18214eed62',
            new Category('1', '1'),
            new Money(123, new Currency('PLN'))
        );
        $deletedBudget->delete();

        $duplicatedBudget1 = Budget::createWithData(
            'bc912b21-8b0b-4635-82df-f74a09fd6000',
            'name',
            'c8090c8b-5dca-4335-a1aa-3c18214eed62',
            new Category('1', '1'),
            new Money(123, new Currency('PLN'))
        );
        $duplicatedBudget2 = Budget::createWithData(
            'bc912b21-8b0b-4635-82df-f74a09fd6000',
            'name',
            'c8090c8b-5dca-4335-a1aa-3c18214eed62',
            new Category('1', '1'),
            new Money(123, new Currency('PLN'))
        );

        $this->inMemoryBudgetRepository = new InMemoryBudgetRepository([
            $properBudget,
            $deletedBudget,
            $duplicatedBudget1,
            $duplicatedBudget2,
        ]);
    }

    /**
     * @test
     */
    public function whenTryGetExistingBudgetAndIsNotDeletedThenIsReturned(): void
    {
        $budget = $this->inMemoryBudgetRepository->getById(
            'bc912b21-8b0b-4635-82df-f74a09fd69e1'
        );

        $this->assertSame(
            'bc912b21-8b0b-4635-82df-f74a09fd69e1',
            $budget->id()
        );
    }

    /**
     * @test
     */
    public function whenTryGetDeletedBudgetWithDeclaredOptionThenShouldBeReturned(): void
    {
        $budget = $this->inMemoryBudgetRepository->getById(
            'bc912b21-8b0b-4635-82df-f74a09fd68i0',
            [
                'deleted' => true
            ]
        );

        $this->assertSame(
            'bc912b21-8b0b-4635-82df-f74a09fd68i0',
            $budget->id()
        );
    }

    /**
     * @test
     */
    public function whenTryGetDeletedBudgetFromRepositoryThenExceptionThrows()
    {
        $this->expectException(BudgetDoesNotExist::class);

        $this->inMemoryBudgetRepository->getById(
            'bc912b21-8b0b-4635-82df-f74a09fd68i0'
        );
    }

    /**
     * @test
     */
    public function whenTryGetDuplicatedBudgetFromRepositoryThenExceptionThrows()
    {
        $this->expectException(UnexpectedDuplicates::class);

        $this->inMemoryBudgetRepository->getById(
            'bc912b21-8b0b-4635-82df-f74a09fd6000'
        );
    }

    /**
     * @test
     */
    public function whenTBudgetWasSavedThenGetByIdWillReturnHim()
    {
        $budget = Budget::createWithData(
            'bc912b21-8b0b-4635-82df-f74a09fd601',
            'name',
            'c8090c8b-5dca-4335-a1aa-3c18214eed62',
            new Category('1', '1'),
            new Money(123, new Currency('PLN'))
        );

        $this->inMemoryBudgetRepository->save($budget);

        $this->assertSame(
            $budget,
            $this->inMemoryBudgetRepository->getById(
                'bc912b21-8b0b-4635-82df-f74a09fd601'
            )
        );
    }
}
