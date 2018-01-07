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
}
