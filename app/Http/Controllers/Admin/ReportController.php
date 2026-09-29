<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from', Carbon::now()->startOfMonth()->toDateString());
        $to   = $request->input('to',   Carbon::now()->endOfMonth()->toDateString());

        $ordersQ = Order::where('status','selesai')
            ->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59']);
        $revenue = (float) $ordersQ->sum('total_price');
        $orderCount = (int) $ordersQ->count();

        $expensesQ = Expense::whereBetween('expense_date', [$from, $to]);
        $expense = (float) $expensesQ->sum('amount');
        $profit  = $revenue - $expense;

        // service breakdown
        $breakdown = Order::selectRaw('service_type, SUM(total_price) as total, COUNT(*) as jml')
            ->where('status','selesai')
            ->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59'])
            ->groupBy('service_type')->get();

        return view('admin.reports', compact('from','to','revenue','expense','profit','orderCount','breakdown'));
    }
}
