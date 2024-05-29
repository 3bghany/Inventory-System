<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseService
{
    public function storeExpense(Request $request){
        $expense = new Expense;
        $expense->details = $request->details;
        $expense->amount = $request->amount;
        $expense->expense_date = date('d/m/Y');

        $expense->save();

        return $expense;
    }

    public function updateExpense(Expense $expense,Request $request){
        $expense->details = $request->details;
        $expense->amount = $request->amount;
        $expense->expense_date = date('d/m/Y');
        $expense->save();

        return $expense;
    }

}