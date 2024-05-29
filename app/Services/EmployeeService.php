<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Traits\ManageFile;

class EmployeeService
{
    use ManageFile;
    public function storeEmployee(Request $request){
        $employee = new Employee;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->salary = $request->salary;
        $employee->phone = $request->phone;
        $employee->joining_date = $request->joining_date;
        $employee->nid = $request->nid;

        if($request->photo)
            $employee->photo = $this->storeBase64File($request->photo ,'employees');

        $employee->save();
        
        return $employee;
    }

    public function updateEmployee(Employee $employee,Request $request){
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->salary = $request->salary;
        $employee->phone = $request->phone;
        $employee->joining_date = $request->joining_date;
        $employee->nid = $request->nid;

        if($request->newPhoto){
            $oldPhoto=$employee->photo;
            $employee->photo = $this->storeBase64File($request->newPhoto ,'employees');
            $oldPhoto != "/backend/img/boy.png" ?unlink(substr($oldPhoto, 1)):false;
        }
        $employee->save();

        return $employee;
    }
}