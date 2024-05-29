<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;

use App\Services\ProductService;
use App\Traits\ManageFile;

class ProductController extends Controller
{
    use ManageFile;
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */

    public function getProducts($shuffle = false)
    {
        $products=$this->productService->getProducts($shuffle);
        
        return response()->json([
            'status' => 'success',
            'message' => 'All products viewed successfully',
            'data' => ProductResource::collection($products),
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product=$this->productService->storeProduct($request);
        return response()->json([
            'status' => 'success',
            'message' => 'product inserted successfully',
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Product::find($id)){
            return response()->json([
                'status' => 'success',
                'message' => 'product viewed successfully',
                'data' => ProductResource::collection(Product::all()->where('id',$id)),
            ]);
        }
        return response()->json([
            'status' => 'warning',
            'message' => 'No such product to show',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $updatedProduct = $this->productService->updateProduct($product, $request);

        if($updatedProduct->wasChanged()){
        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => new ProductResource($updatedProduct),
        ]);
        }
        return response()->json([
            'status' => 'warning',
            'message' => "you didn't apply any changes",
            'data' => new ProductResource($updatedProduct),
        ]);
    }
 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Product::where('id',$id)->first();
        if(($product->photo)!="/backend/img/product.png" ){
            unlink(substr($product->photo, 1));
        }
        Product::where('id',$id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
        ]);
    }

    public function search($query){
        $products=Product::search($query)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'All products results found successfully',
            'data' => ProductResource::collection($products),
        ]);
    }
}
