<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function pay(Request $request,$id)
    {
        $validate = $request->validate([
            'salary_month' => 'required',
            'salary' => 'required|integer',
        ]);
        $check=DB::table('salaries')
        ->where('employee_id',$id)
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
        $data = array();
        $data['employee_id'] = $id;
        $data['amount'] = $request->salary;
        $data['salary_date'] = date('d/m/Y');
        $data['salary_month'] = $request->salary_month;
        $data['salary_year'] = date('Y');

        DB::table('salaries')->insert($data);
        return response()->json([
            'status' => 'success',
            'message'=> 'Salary Paid Successfuly'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
