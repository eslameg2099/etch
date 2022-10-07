<?php


namespace App\Interfaces;


interface CategoriesRepositoryInterface
{
    public function getAllCategories();

    public function getCategoryById($id);

    public function storeOrUpdate($request, $id = null);

    public function destroy($id);

}
