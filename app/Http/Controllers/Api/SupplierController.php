<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suppliers;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\Base64ImageDecoder;
use App\Http\Resources\SupplierResource;
use DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All suppliers viewed successfully',
            'data' => SupplierResource::collection(Suppliers::all()),
        ], 203);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:Suppliers|email',
            'address' => 'required',
            'shopname' => 'required',
            'phone' => 'required|digits:11',
        ]);
        $supplier = new Suppliers;
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->shopname = $request->shopname;
        $supplier->phone = $request->phone;

        if($request->photo){
            $pos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time(). "." . $ext[1];
            $base_64 = explode(',', $request->photo);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($base_64[1],Base64ImageDecoder::class);
            $image = $image->resize(300, 300);
            // Storage::disk('public')->put("suppliers/".$fileName,base64_decode($base_64[1]));
            $path = '/backend/suppliers/'.$fileName;
            $image->save('backend/suppliers/'.$fileName);
            $supplier->photo = $path;
        }
        $supplier->save();
        // $id = Suppliers::all()->last()->id;
        return response()->json([
            'status' => 'true',
            'message' => 'Supplier inserted successfully',
            'data' => SupplierResource::collection(Suppliers::all()->where('id',$supplier->id))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Suppliers::find($id)){
            return response()->json([
                'status' => 'success',
                'message' => 'supplier viewed successfully',
                'data' => SupplierResource::collection(Suppliers::all()->where('id',$id)),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'No such record to show',
            'data' => SupplierResource::collection(Suppliers::all()->where('id',$id)),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $validate = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|digits:11',
        ]);
        $Supplier = Suppliers::find($id);
        if (!strcasecmp($Supplier->email, $request->email)) {
            $validate = $request->validate([
                'email' => 'required|email',
            ]);
        } else {
            $validate = $request->validate([
                'email' => 'required|unique:Suppliers|email',
                
            ]);
        }
            // using     Eloquent ORM
       $Supplier->name = $request->name;
        $Supplier->email = $request->email;
        $Supplier->address = $request->address;
        $Supplier->shopname = $request->shopname;
        $Supplier->phone = $request->phone;
        // $supplier = array();

        // $supplier['name'] = $request->name;
        // $supplier['email'] = $request->email;
        // $supplier['address'] = $request->address;
        // $supplier['shopname'] = $request->shopname;
        // $supplier['phone'] = $request->phone;

        if($request->newPhoto){
            $pos = strpos($request->newPhoto, ';');
            $sub = substr($request->newPhoto, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time(). "." . $ext[1];
            $base_64 = explode(',', $request->newPhoto);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($base_64[1],Base64ImageDecoder::class);
            $image = $image->resize(300, 300);
            // Storage::disk('public')->put("suppliers/".$fileName,base64_decode($base_64[1]));
            $path = 'backend/suppliers/'.$fileName;
            $image->save($path);
            $Supplier->photo != "/backend/img/boy.png" ?unlink(substr($Supplier->photo, 1)):false;
            // $supplier['photo'] = '/'.$path;
            $Supplier->photo = '/'.$path;
        }
        $Supplier->save();
        // DB::table('suppliers')->where('id', $id)->update($supplier);
        if($Supplier->wasChanged()){
        return response()->json([
            'status' => 'true',
            'message' => 'Supplier updated successfully',
            'data' => SupplierResource::collection(Suppliers::all()->where('id',$id)),
        ]);
        }
        return response()->json([
            'status' => 'false',
            'message' => "you didn't apply any changes",
            'data' => SupplierResource::collection(Suppliers::all()->where('id',$id)),
        ]);
        
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier=DB::table('suppliers')->where('id',$id)->first();
        if(($supplier->photo)!="/backend/img/boy.png" ){
            unlink(substr($supplier->photo, 1));
        }
        DB::table('suppliers')->where('id',$id)->delete();
    }

    public function search($name){
        return response()->json([
            'status' => 'success',
            'message' => 'suppliers found successfully',
            'data' => SupplierResource::collection(Suppliers::query()
            ->where('name', 'LIKE', "%" . $name . "%")
            ->orWhere('name', 'LIKE', "%" . ucfirst($name) . "%")
            ->orWhere('name', 'LIKE', "%" . strtolower($name) . "%")
            ->orWhere('name', 'LIKE', "%" . strtoupper($name) . "%")
            ->get()),
        ], 203);

        // $suppliers =Suppliers::search($request->search)->get();
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'suppliers found successfully',
        //     'data' => SupplierResource::collection($suppliers),
        // ], 203);
    }

}
