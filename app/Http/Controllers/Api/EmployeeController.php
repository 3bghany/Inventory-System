<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;

use App\Services\EmployeeService;
use App\Traits\ManageFile;


class EmployeeController extends Controller
{
    use ManageFile;
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All employees viewed successfully',
            'data' => EmployeeResource::collection(Employee::all()),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {   
        $employee=$this->employeeService->storeEmployee($request);
        return response()->json([
            'status' => 'success',
            'message' => 'employee inserted successfully',
            'data' => new EmployeeResource($employee),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Employee::find($id)){
            return response()->json([
                'status' => 'success',
                'message' => 'employee viewed successfully',
                'data' => EmployeeResource::collection(Employee::all()->where('id',$id)),
            ]);
        }
        return response()->json([
            'status' => 'warning',
            'message' => 'No such employee to show',
            'data' => EmployeeResource::collection(Employee::all()->where('id',$id)),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(UpdateEmployeeRequest $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        $updatedEmployee=$this->employeeService->updateEmployee($employee,$request);
        
        if($updatedEmployee->wasChanged()){
        return response()->json([
            'status' => 'success',
            'message' => 'employee updated successfully',
            'data' => new EmployeeResource($updatedEmployee),
        ]);
        }
        return response()->json([
            'status' => 'warning',
            'message' => "you didn't apply any changes",
            'data' => new EmployeeResource($updatedEmployee),
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee=Employee::where('id',$id)->first();
        if(($employee->photo)!="/backend/img/boy.png" ){
            unlink(substr($employee->photo, 1));
        }
        Employee::where('id',$id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'employee deleted successfully',
        ]);
    }
}
