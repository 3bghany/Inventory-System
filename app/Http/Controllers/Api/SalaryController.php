<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salary;
use App\Http\Requests\PaySalaryRequest;
use App\Services\SalaryService;

class SalaryController extends Controller
{
    protected $salaryService;

    public function __construct(SalaryService $salaryService)
    {
        $this->salaryService = $salaryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function pay(PaySalaryRequest $request,$id)
    {

        $check=Salary::where('employee_id',$id)
                    ->where('salary_month',$request->salary_month)
                    ->where('salary_year',date('Y'))
                    ->first();
        
        if($check){
            return response()->json([
                'status' => 'error',
                'message'=> 'Salary already Paid',
                'data'=> $check,
            ]);
        }
        
        $this->salaryService->paySalary($request,$id);

        return response()->json([
            'status' => 'success',
            'message'=> 'Salary Paid Successfuly',
        ]);
    }

}
