<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employees;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\Base64ImageDecoder;
use App\Http\Resources\EmployeeResource;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        // $employee = DB::table('Employees')->get();
        // $employee = Employees::latest()->paginate(1);
        return response()->json([
            'status' => 'success',
            'message' => 'All employees viewed successfully',
            'data' => EmployeeResource::collection(Employees::all()),
        ], 203);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:Employees|email',
            'address' => 'required',
            'salary' => 'required|integer',
            'phone' => 'required|digits:11',
            'joining_date' => 'required',
        ]);
        $employees = new Employees;
        $employees->name = $request->name;
        $employees->email = $request->email;
        $employees->address = $request->address;
        $employees->salary = $request->salary;
        $employees->phone = $request->phone;
        $employees->joining_date = $request->joining_date;

        if($request->nid){
            $validate = $request->validate([
                'nid' => 'unique:Employees|digits:14',
            ]);
            $employees->nid = $request->nid;
        }

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
            $path = '/backend/employees/'.$fileName;
            $image->save('backend/employees/'.$fileName);
            $employees->photo = $path;
        }
        $employees->save();
        $id = Employees::all()->last()->id;
        return response()->json([
            'status' => 'true',
            'message' => 'employee inserted successfully',
            'data' => EmployeeResource::collection(Employees::all()->where('id',$id))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Employees::find($id)){
            return response()->json([
                'status' => 'success',
                'message' => 'employee viewed successfully',
                'data' => EmployeeResource::collection(Employees::all()->where('id',$id)),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'No such record to show',
            'data' => EmployeeResource::collection(Employees::all()->where('id',$id)),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'salary' => 'required|integer',
            'phone' => 'required|digits:11',
            'joining_date' => 'required',
        ]);
        $Employee = Employees::find($id);
        if (!strcasecmp($Employee->email, $request->email)) {
            $validate = $request->validate([
                'email' => 'required|email',
            ]);
        } else {
            $validate = $request->validate([
                'email' => 'required|unique:Employees|email',
                
            ]);
        }

        if($request->nid)
            if(!strcasecmp($Employee->nid, $request->nid)){
            $validate = $request->validate(['nid' => 'digits:14',]);
            }else{
                $validate = $request->validate(['nid' => 'unique:Employees|digits:14',]);
            }
            // using     Eloquent ORM
       $Employee->name = $request->name;
        $Employee->email = $request->email;
        $Employee->address = $request->address;
        $Employee->salary = $request->salary;
        $Employee->phone = $request->phone;
        $Employee->joining_date = $request->joining_date;
        $Employee->nid = $request->nid;
        // $employee = array();

        // $employee['name'] = $request->name;
        // $employee['email'] = $request->email;
        // $employee['address'] = $request->address;
        // $employee['salary'] = $request->salary;
        // $employee['phone'] = $request->phone;
        // $employee['joining_date'] = $request->joining_date;
        // $employee['nid'] = $request->nid;

        if($request->newPhoto){
            $pos = strpos($request->newPhoto, ';');
            $sub = substr($request->newPhoto, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time(). "." . $ext[1];
            $base_64 = explode(',', $request->newPhoto);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($base_64[1],Base64ImageDecoder::class);
            $image = $image->resize(300, 300);
            // Storage::disk('public')->put("employees/".$fileName,base64_decode($base_64[1]));
            $path = 'backend/employees/'.$fileName;
            $image->save($path);
            $Employee->photo != "/backend/img/boy.png" ?unlink(substr($Employee->photo, 1)):false;
            // $employee['photo'] = '/'.$path;
            $Employee->photo = '/'.$path;

        }
        $Employee->save();
        // DB::table('employees')->where('id', $id)->update($employee);
        if($Employee->wasChanged()){
        return response()->json([
            'status' => 'success',
            'message' => 'employee updated successfully',
            'data' => EmployeeResource::collection(Employees::all()->where('id',$id)),
        ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => "you didn't apply any changes",
            'data' => EmployeeResource::collection(Employees::all()->where('id',$id)),
        ]);
        
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee=DB::table('employees')->where('id',$id)->first();
        if(($employee->photo)!="/backend/img/boy.png" ){
            unlink(substr($employee->photo, 1));
        }
        DB::table('employees')->where('id',$id)->delete();
    }
}
