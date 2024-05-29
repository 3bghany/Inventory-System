<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Traits\ManageFile;

class CustomerService
{
    use ManageFile;
    public function storeCustomer(Request $request){
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->phone = $request->phone;

        if($request->photo)
            $customer->photo = $this->storeBase64File($request->photo ,'customers');

        $customer->save();

        return $customer;
    }
    public function updateCustomer(Customer $customer,Request $request){
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->phone = $request->phone;

        if($request->newPhoto){
            $oldPhoto=$customer->photo;
            $customer->photo = $this->storeBase64File($request->newPhoto ,'customers');
            $oldPhoto != "/backend/img/boy.png" ?unlink(substr($oldPhoto, 1)):false;
        }
        $customer->save();

        return $customer;
    }

}