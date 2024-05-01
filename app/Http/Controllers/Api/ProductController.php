<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\Base64ImageDecoder;
use App\Http\Resources\ProductResource;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // $products= DB::table('Products')
        //                 ->join('categories','Products.category_id','categories.id')
        //                 ->leftJoin('suppliers','Products.supplier_id','suppliers.id')
        //                 ->select('suppliers.name as supplier_name','categories.name as category_name','Products.*')
        //                 ->OrderBy('Products.id','DESC')
        //                 ->get();

        $products = Product::join('categories','categories.id','=','Products.category_id')
                            ->leftJoin('suppliers','suppliers.id','=','Products.supplier_id')
                            ->orderBy('Products.id','DESC')
                            ->get(['suppliers.name as supplier_name','categories.name as category_name','Products.*']);
        return response()->json([
            'status' => 'success',
            'message' => 'All products viewed successfully',
            'data' => ProductResource::collection($products),
        ], 203);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|unique:Products|max:255',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'buying_price' => 'required|integer',
            'selling_price' => 'required|integer',
            'root' => 'required',
            'buying_date' => 'required',
            'quantity' => 'required',
        ]);
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
            $pos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time(). "." . $ext[1];
            $base_64 = explode(',', $request->photo);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($base_64[1],Base64ImageDecoder::class);
            $image = $image->resize(300, 300);
            // Storage::disk('public')->put("employees/".$fileName,base64_decode($base_64[1]));
            $path = '/backend/products/'.$fileName;
            $image->save('backend/products/'.$fileName);
            $product->photo = $path;
        }
        $product->save();
        return response()->json([
            'status' => 'true',
            'message' => 'product inserted successfully',
            'data' => ProductResource::collection(Product::all()->where('id',$product->id))
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
            'name' => 'required|max:255',
            'category_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'buying_price' => 'required|integer',
            'selling_price' => 'required|integer',
            'root' => 'required',
            'buying_date' => 'required',
            'quantity' => 'required',
        ]);
        $Product = Product::find($id);
        if (!strcasecmp($Product->code, $request->code)) {
            $validate = $request->validate([
                'code' => 'required|max:255',
            ]);
        } else {
            $validate = $request->validate([
                'code' => 'required|unique:Products|max:255',
                
            ]);
        }
            // using     Eloquent ORM
       $Product->name = $request->name;
        $Product->category_id = $request->category_id;
        $Product->supplier_id = $request->supplier_id;
        $Product->buying_price = $request->buying_price;
        $Product->selling_price = $request->selling_price;
        $Product->root = $request->root;
        $Product->buying_date = $request->buying_date;
        $Product->quantity = $request->quantity;
        $Product->code = $request->code;
        // $Product = array();

        // $Product['name'] = $request->name;
        // $Product['email'] = $request->email;
        // $Product['address'] = $request->address;
        // $Product['shopname'] = $request->shopname;
        // $Product['phone'] = $request->phone;

        if($request->newPhoto){
            $pos = strpos($request->newPhoto, ';');
            $sub = substr($request->newPhoto, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time(). "." . $ext[1];
            $base_64 = explode(',', $request->newPhoto);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($base_64[1],Base64ImageDecoder::class);
            $image = $image->resize(300, 300);
            // Storage::disk('public')->put("Products/".$fileName,base64_decode($base_64[1]));
            $path = 'backend/products/'.$fileName;
            $image->save($path);
            $Product->photo != "/backend/img/product.png" ?unlink(substr($Product->photo, 1)):false;
            // $Product['photo'] = '/'.$path;
            $Product->photo = '/'.$path;
        }
        $Product->save();
        // DB::table('products')->where('id', $id)->update($Product);
        if($Product->wasChanged()){
        return response()->json([
            'status' => 'true',
            'message' => 'Product updated successfully',
            'data' => ProductResource::collection(Product::all()->where('id',$id)),
        ]);
        }
        return response()->json([
            'status' => 'false',
            'message' => "you didn't apply any changes",
            'data' => ProductResource::collection(Product::all()->where('id',$id)),
        ]);
        
    }
 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=DB::table('Products')->where('id',$id)->first();
        if($product)
        {
        if(($product->photo)!="/backend/img/product.png" ){
            unlink(substr($product->photo, 1));
        }
        DB::table('Products')->where('id',$id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
        ]);
    }
    return response()->json([
        'status' => 'false',
        'message' => 'No such record to delete',
    ]);
    }

    public function GetProductByCategory(string $id){
        $products=DB::table('Products')->where('category_id',$id)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'All products viewed successfully',
            'data' => ProductResource::collection($products),
        ], 203);
    }

    public function fac($number){
        Product::factory()->count($number)->create();
    }
}
