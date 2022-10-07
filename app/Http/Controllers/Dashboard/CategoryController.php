<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\MasterData\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::filter()->paginate();

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());

        $category->addAllMediaFromTokens();

        flash()->success(trans('categories.messages.created'));

        return redirect()->route('dashboard.categories.show', $category);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\MasterData\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\MasterData\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\CategoryRequest $request
     * @param \App\Models\MasterData\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        $category->addAllMediaFromTokens();

        flash()->success(trans('categories.messages.updated'));

        return redirect()->route('dashboard.categories.show', $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\MasterData\Category $category
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();

        flash()->success(trans('categories.messages.deleted'));

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $categories = Category::filter()->onlyTrashed()->paginate();

        return view('dashboard.categories.index', compact('categories'));
    }

    public function restore(Category $category)
    {
        $category->restore();

        flash()->success(trans('categories.messages.restored'));

        return redirect()->route('dashboard.categories.index');
    }
}
