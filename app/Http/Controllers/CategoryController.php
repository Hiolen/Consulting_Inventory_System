<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Category;
use Exception;
use Log;
use Session;

class CategoryController extends Controller
{
    /**
     * The category repository instance.
     *
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * Create a new controller instance.
     *
     * @param  CategoryRepository
     * @return void
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->middleware('auth');
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->findAllCategory();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category($request->all());
        try {
            $category->save();
            Session::flash('flash_message', 'Category added successfully.');
            return redirect()->route('category.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Session::flash('flash_message_error', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->fill($request->all());
        try {
            $category->save();
            Session::flash('flash_message', 'Category updated successfully.');
            return redirect()->route('category.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Session::flash('flash_message_error', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try{
            $category->delete();
            Session::flash('flash_message', 'Category deleted successfully.');
            return redirect()->route('category.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Session::flash('flash_message_error', $e->getMessage());
            return redirect()->back();
        }
    }
}
