<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Traits\ManageFile;
use DB;

class ProductService
{
    use ManageFile;

    public function getProducts($shuffle){

        $products= DB::table('Products')
                        ->join('categories','Products.category_id','=','categories.id')
                        ->leftJoin('suppliers','Products.supplier_id','=','suppliers.id')
                        ->select('suppliers.name as supplier_name','categories.name as category_name','Products.*')
                        ->OrderBy('Products.id','DESC')
                        ->get();
        if($shuffle)
            $products =$products->shuffle();
        return $products;
    }

    public function storeProduct(Request $request){
        $product = new Product;
        $product->name = $request->name;
        $product->code = $request->code;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->root = $request->root;
        $product->buying_date = $request->buying_date;
        $product->quantity = $request->quantity;

        if($request->photo){
            $product->photo = $this->storeBase64File($request->photo ,'products');
        }
        $product->save();
        return $product;
    }

    public function updateProduct(Product $product,Request $request){
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->root = $request->root;
        $product->buying_date = $request->buying_date;
        $product->quantity = $request->quantity;
        $product->code = $request->code;


        if($request->newPhoto){
            $oldPhoto=$product->photo;
            $product->photo = $this->storeBase64File($request->newPhoto ,'products');
            $oldPhoto != "/backend/img/product.png" ?unlink(substr($oldPhoto, 1)):false;
        }
        $product->save();
        
        return $product;
    }
}