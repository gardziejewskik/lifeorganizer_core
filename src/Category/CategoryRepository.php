<?php

namespace LifeOrganizer\Core\Category;

use LifeOrganizer\Core\Budget\Model\CategoryDoesNotExist;

interface CategoryRepository
{
    /**
     * @param string $name
     * @throws CategoryDoesNotExist
     * @return Category
     */
    public function getByName(string $name): Category;

    /**
     * @param string $id
     * @throws CategoryDoesNotExist
     * @return Category
     */
    public function getById(string $id): Category;
    public function exist(string $id): bool;
    public function getAll(): array;
    public function add(Category $category): void;
    public function update(Category $category): void;
    public function delete(Category $category): void;
}
