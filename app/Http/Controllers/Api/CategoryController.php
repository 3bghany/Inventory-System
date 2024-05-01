<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All Categories viewed successfully',
            'data' => CategoryResource::collection(Category::all()),
        ], 203);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',

        ]);
        $category = new Category;
        $category->name = $request->name;


        $category->save();
        return response()->json([
            'status' => 'true',
            'message' => 'category inserted successfully',
            'data' => CategoryResource::collection(Category::all()->where('id',$category->id))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category=Category::find($id);
        if(Category::find($id)){
            return response()->json([
                'status' => 'success',
                'message' => 'category viewed successfully',
                'data' => $category->products->all(),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'No such record to show',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required',

        ]);
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();

        if($category->wasChanged()){
            return response()->json([
                'status' => 'true',
                'message' => 'category updated successfully',
                'data' => CategoryResource::collection(Category::all()->where('id',$id)),
            ]);
            }
            return response()->json([
                'status' => 'false',
                'message' => "you didn't apply any changes",
                'data' => CategoryResource::collection(Category::all()->where('id',$id)),
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
            'status' => 'true',
            'message' => 'Product deleted successfully',
        ]);
    }
    return response()->json([
        'status' => 'false',
        'message' => 'No such record to delete',
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
        ], 200);
    }
}
