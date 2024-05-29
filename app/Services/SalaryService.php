<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Salary;

class SalaryService
{
    public function paySalary(Request $request,$id){
        
        $data = new Salary;
        $data->employee_id = $id;
        $data->amount = $request->salary;
        $data->salary_date = date('d/m/Y');
        $data->salary_month = $request->salary_month;
        $data->salary_year = date('Y');
        $data->save();

    }
}