<?php declare(strict_types=1);

namespace LifeOrganizer\Core\Budget;

use Countable;
use LifeOrganizer\Core\Budget\Exception\BudgetDoesNotExist;
use LifeOrganizer\Core\Budget\Exception\UnexpectedDuplicates;
use LifeOrganizer\Core\Budget\Model\Budget;

class InMemoryBudgetRepository implements BudgetRepository, Countable
{
    /**
     * @var array
     */
    private $budgets;

    public function __construct(array $budgets = [])
    {
        $this->budgets = $budgets;
    }

    /**
     * @param string $id
     * @param array $options
     * @return Budget
     *
     * @throws BudgetDoesNotExist
     * @throws UnexpectedDuplicates
     */
    public function getById(
        string $id,
        array $options = ['deleted' => false]
    ): Budget
    {
        $data = array_filter($this->budgets, function($budget) use ($id) {
            /** @var Budget $budget */
            return $budget->id() === $id && !$budget->deleted();
        });

        if (empty($data)) {
            throw new BudgetDoesNotExist();
        }

        if (count($data) > 1) {
            throw new UnexpectedDuplicates();
        }

        return reset($data);
    }

    public function save(Budget $budget): void
    {
        $this->budgets[] = $budget;
    }

    public function count(): int
    {
        return count($this->budgets);
    }
}