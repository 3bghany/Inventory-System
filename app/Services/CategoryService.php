<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryService
{
    public function storeCategory(Request $request){

        $category = new Category;
        $category->name = $request->name;

        $category->save();
        return $category;
    }

    public function updateCategory(Category $category,Request $request){
        
        $category->name = $request->name;
        $category->save();
        
        return $category;
    }
}