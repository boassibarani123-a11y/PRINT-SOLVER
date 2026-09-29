<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest('expense_date')->paginate(15);
        $total = (float) Expense::sum('amount');
        return view('admin.expenses.index', compact('expenses','total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:150',
            'description'  => 'nullable|string|max:500',
            'amount'       => 'required|numeric|min:0',
            'category'     => 'required|in:operasional,tinta,kertas,listrik,gaji,lainnya',
            'expense_date' => 'required|date',
        ]);
        Expense::create($data);
        return back()->with('success', 'Pengeluaran ditambahkan.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Pengeluaran dihapus.');
    }
}
