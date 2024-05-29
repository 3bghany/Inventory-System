<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use DB;

use App\Services\SupplierService;
use App\Traits\ManageFile;

class SupplierController extends Controller
{
    use ManageFile;
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All suppliers viewed successfully',
            'data' => SupplierResource::collection(Supplier::all()),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $supplier=$this->supplierService->storeSupplier($request);
        return response()->json([
            'status' => 'success',
            'message' => 'Supplier inserted successfully',
            'data' => new SupplierResource($supplier),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Supplier::find($id)){
            return response()->json([
                'status' => 'success',
                'message' => 'supplier viewed successfully',
                'data' => SupplierResource::collection(Supplier::all()->where('id',$id)),
            ]);
        }
        return response()->json([
            'status' => 'warning',
            'message' => 'No such record to show',
            'data' => SupplierResource::collection(Supplier::all()->where('id',$id)),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, string $id)
    {
        
        $supplier = Supplier::findOrFail($id);
        $updatedSupplier=$this->supplierService->updateSupplier($supplier,$request);
        if($updatedSupplier->wasChanged()){
        return response()->json([
            'status' => 'success',
            'message' => 'Supplier updated successfully',
            'data' => new SupplierResource($updatedSupplier),
        ]);
        }
        return response()->json([
            'status' => 'warning',
            'message' => "you didn't apply any changes",
            'data' => new SupplierResource($updatedSupplier),
        ]);
        
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier=Supplier::where('id',$id)->first();
        if(($supplier->photo)!="/backend/img/boy.png" ){
            unlink(substr($supplier->photo, 1));
        }
        Supplier::where('id',$id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'supplier deleted successfully',
        ]);
    }

    public function search($name){
        return response()->json([
            'status' => 'success',
            'message' => 'suppliers found successfully',
            'data' => SupplierResource::collection(Supplier::query()
            ->where('name', 'LIKE', "%" . $name . "%")
            ->orWhere('name', 'LIKE', "%" . ucfirst($name) . "%")
            ->orWhere('name', 'LIKE', "%" . strtolower($name) . "%")
            ->orWhere('name', 'LIKE', "%" . strtoupper($name) . "%")
            ->get()),
        ]);

        // $suppliers =Suppliers::search($request->search)->get();
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'suppliers found successfully',
        //     'data' => SupplierResource::collection($suppliers),
        // ]);
    }

}
