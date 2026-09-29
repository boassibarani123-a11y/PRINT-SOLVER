<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $monthStart = $now->copy()->startOfMonth();

        $revenueMonth = (float) Order::where('status', 'selesai')
            ->whereBetween('created_at', [$monthStart, $now])->sum('total_price');
        $expenseMonth = (float) Expense::whereBetween('expense_date', [$monthStart->toDateString(), $now->toDateString()])->sum('amount');
        $profitMonth  = $revenueMonth - $expenseMonth;

        $revenueAll = (float) Order::where('status', 'selesai')->sum('total_price');
        $expenseAll = (float) Expense::sum('amount');
        $profitAll  = $revenueAll - $expenseAll;

        // 12-month chart
        $months = [];
        $revenueSeries = [];
        $expenseSeries = [];
        for ($i = 11; $i >= 0; $i--) {
            $m = $now->copy()->subMonths($i);
            $start = $m->copy()->startOfMonth();
            $end   = $m->copy()->endOfMonth();
            $months[] = $m->format('M Y');
            $revenueSeries[] = (float) Order::where('status', 'selesai')
                ->whereBetween('created_at', [$start, $end])->sum('total_price');
            $expenseSeries[] = (float) Expense::whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])->sum('amount');
        }

        $statusCounts = [
            'pending'    => Order::where('status', 'pending')->count(),
            'proses'     => Order::where('status', 'proses')->count(),
            'selesai'    => Order::where('status', 'selesai')->count(),
            'dibatalkan' => Order::where('status', 'dibatalkan')->count(),
        ];

        $recentOrders = Order::latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'revenueMonth','expenseMonth','profitMonth',
            'revenueAll','expenseAll','profitAll',
            'months','revenueSeries','expenseSeries',
            'statusCounts','recentOrders'
        ));
    }
}
