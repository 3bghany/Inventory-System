<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All Categories viewed successfully',
            'data' => CategoryResource::collection(Category::all()),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->storeCategory($request);
        return response()->json([
            'status' => 'success',
            'message' => 'category inserted successfully',
            'data' => new CategoryResource($category),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   $category = Category::find($id);
        if(Category::find($id)){
            return response()->json([
                'status' => 'success',
                'message' => 'category viewed successfully',
                'data' => CategoryResource::collection(Category::all()->where('id',$id)),
            ]);
        }
        return response()->json([
            'status' => 'warning',
            'message' => 'No such category to show',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        
        $category = Category::findOrFail($id);
        $updatedCategory = $this->categoryService->updateCategory($category,$request);

        if($updatedCategory->wasChanged()){
            return response()->json([
                'status' => 'success',
                'message' => 'category updated successfully',
                'data' => new CategoryResource($updatedCategory),
            ]);
            }
            return response()->json([
                'status' => 'warning',
                'message' => "you didn't apply any changes",
                'data' => new CategoryResource($updatedCategory),
            ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Category::find($id)){
        Category::find($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'category deleted successfully',
        ]);
    }
    return response()->json([
        'status' => 'warning',
        'message' => 'No such category to delete',
    ]);
    }

    public function search($name){
        return response()->json([
            'status' => 'success',
            'message' => 'Categories found successfully',
            'data' => CategoryResource::collection(Category::query()
            ->where('name', 'LIKE', "%" . $name . "%")
            ->orWhere('name', 'LIKE', "%" . ucfirst($name) . "%")
            ->orWhere('name', 'LIKE', "%" . strtolower($name) . "%")
            ->orWhere('name', 'LIKE', "%" . strtoupper($name) . "%")
            ->get()),
        ]);
    }
}
