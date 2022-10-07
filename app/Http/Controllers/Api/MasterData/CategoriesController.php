<?php

namespace App\Http\Controllers\Api\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterData\CategoryResource;
use App\Http\Resources\ShopResource;
use App\Interfaces\CategoriesRepositoryInterface;
use App\Traits\RepositoryResponseTrait;
use Illuminate\Http\Request;
use Laraeast\LaravelSettings\Facades\Settings;

class CategoriesController extends Controller
{
    use RepositoryResponseTrait;
    private $categoryRepo;

    public function __construct(CategoriesRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index() {
        $slider = collect();
        if (Settings::instance('category_slider')) {
            $slider = Settings::instance('category_slider')->getMedia('category_slider')->map->getFullUrl();
        }

        $categories =   $this->categoryRepo->getAllCategories();
        return $this->success([
            'categories'    =>  CategoryResource::collection($categories->get()),
            'slider' => $slider
        ]);
    }

    public function show($id) {
        $category   =   $this->categoryRepo->getCategoryById($id);

        return $category ?
            $this->success(['category'    =>  new CategoryResource($category)]) :
            $this->error(['message' => trans('errors.cannot_find_this_category')]);
    }

    public function categoryShops($id) {
        $category   =   $this->categoryRepo->getCategoryById($id);

        return $category ?
            $this->success([
                'category'  =>  new CategoryResource($category),
                'shops'     =>  ShopResource::collection($category->shops()->latest('rate')->simplePaginate())
            ]) :
            $this->error(['message' => trans('errors.cannot_find_this_category')]);
    }
}
