<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\ManageFile;
use App\Models\Supplier;

class SupplierService
{
    use ManageFile;

    public function storeSupplier(Request $request){
        $supplier = new Supplier;
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->shopname = $request->shopname;
        $supplier->phone = $request->phone;

        if($request->photo){
            $supplier->photo = $this->storeBase64File($request->photo ,'suppliers');
        }
        $supplier->save();

        return $supplier;
    }

    public function updateSupplier(Supplier $supplier,Request $request){
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->shopname = $request->shopname;
        $supplier->phone = $request->phone;


        if($request->newPhoto){
            $oldPhoto=$supplier->photo;
            $supplier->photo = $this->storeBase64File($request->newPhoto ,'suppliers');
            $oldPhoto != "/backend/img/boy.png" ?unlink(substr($oldPhoto, 1)):false;
        }
        $supplier->save();

        return $supplier;
    }
    
}