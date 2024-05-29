<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;

use App\Traits\ManageFile;
use App\Services\CustomerService;


class CustomerController extends Controller
{
    use ManageFile;
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All Customers viewed successfully',
            'data' => CustomerResource::collection(Customer::all()),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer=$this->customerService->storeCustomer($request);

        return response()->json([
            'status' => 'true',
            'message' => 'Customer inserted successfully',
            'data' => new CustomerResource($customer),
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
            'status' => 'warning',
            'message' => 'No such Customer to show',
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id)
    {
        $customer = Customer::findOrFail($id);
        $updatedCustomer=$this->customerService->updateCustomer($customer,$request);

        if($updatedCustomer->wasChanged()){
        return response()->json([
            'status' => 'success',
            'message' => 'customer updated successfully',
            'data' => new CustomerResource($updatedCustomer),
        ]);
        }
        return response()->json([
            'status' => 'warning',
            'message' => "you didn't apply any changes",
            'data' => new CustomerResource($updatedCustomer),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer=Customer::where('id',$id)->first();
        if(($customer->photo)!="/backend/img/boy.png" ){
            unlink(substr($customer->photo, 1));
        }
        $customer->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'customer deleted successfully',
        ]);
    }
}
