<?php


namespace App\Repositories;


use App\Interfaces\CategoriesRepositoryInterface;
use App\Models\MasterData\Category;
use App\Traits\RepositoryResponseTrait;

class CategoriesRepository implements CategoriesRepositoryInterface
{
    use RepositoryResponseTrait;

    public function getAllCategories()
    {
        return Category::query()->where('is_active', 1);
    }

    public function getCategoryById($id)
    {
        return Category::query()->where('is_active', 1)->find($id);
    }

    public function storeOrUpdate($request, $id = null)
    {
        // TODO: Implement storeOrUpdate() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

}
