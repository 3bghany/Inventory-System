<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\Base64ImageDecoder;
use App\Http\Resources\CustomerResource;
use DB;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All Customer viewed successfully',
            'data' => CustomerResource::collection(Customer::all()),
        ], 203);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:customers|email',
            'address' => 'required',
            'phone' => 'required|digits:11',
        ]);
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->phone = $request->phone;

        if($request->photo){
            $pos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time(). "." . $ext[1];
            $base_64 = explode(',', $request->photo);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($base_64[1],Base64ImageDecoder::class);
            $image = $image->resize(300, 300);
            // Storage::disk('public')->put("customers/".$fileName,base64_decode($base_64[1]));
            $path = '/backend/customers/'.$fileName;
            $image->save('backend/customers/'.$fileName);
            $customer->photo = $path;
        }
        $customer->save();
        $id = Customer::all()->last()->id;
        return response()->json([
            'status' => 'true',
            'message' => 'Customer inserted successfully',
            'data' => CustomerResource::collection(Customer::all()->where('id',$id))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Customer::find($id)){
            return response()->json([
                'status' => 'success',
                'message' => 'Customer viewed successfully',
                'data' => CustomerResource::collection(Customer::all()->where('id',$id)),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'No such record to show',
            'data' => CustomerResource::collection(Customer::all()->where('id',$id)),
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
        $customer = Customer::find($id);
        if (!strcasecmp($customer->email, $request->email)) {
            $validate = $request->validate([
                'email' => 'required|email',
            ]);
        } else {
            $validate = $request->validate([
                'email' => 'required|unique:customers|email',
                
            ]);
        }
            // using     Eloquent ORM
       $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        // $customer = array();

        // $customer['name'] = $request->name;
        // $customer['email'] = $request->email;
        // $customer['address'] = $request->address;
        // $customer['shopname'] = $request->shopname;
        // $customer['phone'] = $request->phone;

        if($request->newPhoto){
            $pos = strpos($request->newPhoto, ';');
            $sub = substr($request->newPhoto, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time(). "." . $ext[1];
            $base_64 = explode(',', $request->newPhoto);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($base_64[1],Base64ImageDecoder::class);
            $image = $image->resize(300, 300);
            // Storage::disk('public')->put("customers/".$fileName,base64_decode($base_64[1]));
            $path = 'backend/customers/'.$fileName;
            $image->save($path);
            $customer->photo != "/backend/img/boy.png" ?unlink(substr($customer->photo, 1)):false;
            // $customer['photo'] = '/'.$path;
            $customer->photo = '/'.$path;
        }
        $customer->save();
        // DB::table('customers')->where('id', $id)->update($customer);
        if($customer->wasChanged()){
        return response()->json([
            'status' => 'true',
            'message' => 'customer updated successfully',
            'data' => CustomerResource::collection(Customer::all()->where('id',$id)),
        ]);
        }
        return response()->json([
            'status' => 'false',
            'message' => "you didn't apply any changes",
            'data' => CustomerResource::collection(Customer::all()->where('id',$id)),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer=DB::table('customers')->where('id',$id)->first();
        if(($customer->photo)!="/backend/img/boy.png" ){
            unlink(substr($customer->photo, 1));
        }
        DB::table('customers')->where('id',$id)->delete();
    }
}
