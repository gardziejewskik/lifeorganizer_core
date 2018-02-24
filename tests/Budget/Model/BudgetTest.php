<?php declare(strict_types=1);

namespace Test\Budget\Model;

use LifeOrganizer\Core\Budget\Model\Budget;
use LifeOrganizer\Core\Budget\ValueObject\PositionDetails;
use LifeOrganizer\Core\Category\Category;
use Money\Currency;
use Money\Money;
use Test\TestCase;

class BudgetTest extends TestCase
{
    /**
     * @test
     */
    public function whenBudgetIsCreatedThenHasDeclaredValues()
    {
        $budgetName = 'bc912b21-8b0b-4635-82df-f74a09fd69e1';
        $budgetId = 'name';
        $userId = 'c8090c8b-5dca-4335-a1aa-3c18214eed62';
        $category = new Category('1', '1');
        $plannedValue = new Money(123, new Currency('PLN'));

        $budget = Budget::createWithData(
            $budgetId,
            $budgetName,
            $userId,
            $category,
            $plannedValue
        );

        $this->assertTrue($budget->hasCategory($category));
        $this->assertSame($plannedValue->getAmount(), $budget->planned());
        $this->assertSame($budgetId, $budget->id());
    }

    /**
     * @test
     */
    public function whenBudgetNameIsChangedThenBudgetHasNewName()
    {
        $budget = $this->createBudget();
        $budgetNewName = "newName";

        $budget->newName($budgetNewName);

        $this->assertSame($budgetNewName, $budget->name());
    }

    /**
     * @test
     * @dataProvider positionValueAndExpectedBudgetValue
     * @param int[] $positionsValues
     * @param int $expectedValue
     */
    public function whenPositionIsAddedThenBudgetValueIsChanged(
        array $positionsValues, int $expectedValue
    ) {
        $budget = $this->createBudget();

        foreach ($positionsValues as $positionValue) {
            $budget->addPosition(
                new PositionDetails(
                    'bc912b21-8b0b-4635-82df-f74a09fd69e1',
                    new Money($positionValue, new Currency('PLN')),
                    'shopping'
                )
            );
        }

        $expectedMoney = new Money($expectedValue, new Currency('PLN'));
        $this->assertTrue($expectedMoney->equals($budget->value()));
    }

    /**
     * @test
     */
    public function whenPositionIsRemovedThenBudgetValueIsChanged() {
        $budget = $this->createBudget();
        $budgetPosition = $this->createPosition();
        $budget->addPosition($budgetPosition);

        $budget->deletePosition($budgetPosition);

        $expectedMoney = new Money(0, new Currency('PLN'));
        $this->assertTrue($expectedMoney->equals($budget->value()));
    }

    /**
     * @test
     */
    public function whenPositionIsEditedThenBudgetValueIsChanged() {
        $budget = $this->createBudget();
        $budgetPosition = $this->createPosition();
        $budget->addPosition($budgetPosition);
        $editedBudgetPosition = new PositionDetails(
            'bc912b21-8b0b-4635-82df-f74a09fd69e1',
            new Money(100, new Currency('PLN')),
            'shopping'
        );

        $budget->editPosition($budgetPosition, $editedBudgetPosition);

        $expectedMoney = new Money(100, new Currency('PLN'));
        $this->assertTrue($expectedMoney->equals($budget->value()));
    }

    /**
     * @test
     */
    public function whenBudgetIsDeletedThenBudgetStateIsDeleted() {
        $budget = $this->createBudget();

        $budget->delete();

        $this->assertTrue($budget->deleted());
    }

    public function positionValueAndExpectedBudgetValue(): array
    {
        return [
            [
                [ 123, -123 ],
                0
            ],
            [
                [ -123, 123 ],
                0
            ],
            [
                [ -123, 123, 123 ],
                123
            ],
            [
                [ -123, 123, -123 ],
                -123
            ],
            [
                [ -123, 123, 123, 123 ],
                246
            ]
        ];
    }

    private function createBudget(): Budget
    {
        return Budget::createWithData(
            'bc912b21-8b0b-4635-82df-f74a09fd69e1',
            'name',
            'c8090c8b-5dca-4335-a1aa-3c18214eed62',
            new Category('1', '1'),
            new Money(123, new Currency('PLN'))
        );
    }

    private function createPosition(): PositionDetails
    {
        return new PositionDetails(
            'bc912b21-8b0b-4635-82df-f74a09fd69e1',
            new Money(123, new Currency('PLN')),
            'shopping'
        );
    }
}
