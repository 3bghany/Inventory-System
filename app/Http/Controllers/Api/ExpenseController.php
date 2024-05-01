<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Http\Resources\ExpenseResource;
use DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All Expenses viewed successfully',
            'data' => ExpenseResource::collection(Expenses::all()),
        ], 203);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'details' => 'required',
            'amount' => 'required',
        ]);
        $expenses = new Expenses;
        $expenses->details = $request->details;
        $expenses->amount = $request->amount;
        $expenses->expense_date = date('d/m/Y');

        $expenses->save();
        $id = Expenses::all()->last()->id;
        return response()->json([
            'status' => 'true',
            'message' => 'employee inserted successfully',
            'data' => ExpenseResource::collection(Expenses::all()->where('id',$id))
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Expenses::find($id)){
            return response()->json([
                'status' => 'success',
                'message' => 'expense viewed successfully',
                'data' => ExpenseResource::collection(Expenses::all()->where('id',$id)),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'No such record to show',
            'data' => ExpenseResource::collection(Expenses::all()->where('id',$id)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'details' => 'required',
            'amount' => 'required',
        ]);

        $expenses = Expenses::find($id);
        $expenses->details = $request->details;
        $expenses->amount = $request->amount;
        $expenses->expense_date = date('d/m/Y');
        $expenses->save();

        if($expenses->wasChanged()){
            return response()->json([
                'status' => 'true',
                'message' => 'expense updated successfully',
                'data' => ExpenseResource::collection(Expenses::all()->where('id',$id)),
            ]);
            }
            return response()->json([
                'status' => 'false',
                'message' => "you didn't apply any changes",
                'data' => ExpenseResource::collection(Expenses::all()->where('id',$id)),
            ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('expenses')->where('id',$id)->delete();
    }
}
