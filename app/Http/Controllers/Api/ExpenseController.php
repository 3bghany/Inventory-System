<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ExpenseResource;

use App\Services\ExpenseService;

class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All Expenses viewed successfully',
            'data' => ExpenseResource::collection(Expense::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        $expense=$this->expenseService->storeExpense($request);
        return response()->json([
            'status' => 'success',
            'message' => 'expense inserted successfully',
            'data' => new ExpenseResource($expense)
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Expense::find($id)){
            return response()->json([
                'status' => 'success',
                'message' => 'expense viewed successfully',
                'data' => ExpenseResource::collection(Expense::all()->where('id',$id)),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'No such expense to show',
            'data' => ExpenseResource::collection(Expense::all()->where('id',$id)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, string $id)
    {

        $expense = Expense::findOrFail($id);
        $updatedExpense=$this->expenseService->updateExpense($expense,$request);

        if($updatedExpense->wasChanged()){
            return response()->json([
                'status' => 'success',
                'message' => 'expense updated successfully',
                'data' => new ExpenseResource($updatedExpense),
            ]);
            }
            return response()->json([
                'status' => 'warning',
                'message' => "you didn't apply any changes",
                'data' => new ExpenseResource($updatedExpense),
            ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Expense::where('id',$id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'expense deleted successfully',
        ]);
    }
}
