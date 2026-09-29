<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Order::query();
        if ($request->filled('status')) $q->where('status', $request->status);
        if ($request->filled('search')) {
            $s = $request->search;
            $q->where(function ($qq) use ($s) {
                $qq->where('order_code', 'like', "%$s%")
                   ->orWhere('customer_name', 'like', "%$s%")
                   ->orWhere('customer_phone', 'like', "%$s%");
            });
        }
        $orders = $q->latest()->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,proses,selesai,dibatalkan',
        ]);
        $order->update($data);
        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function destroy(Order $order)
    {
        if ($order->file_path && Storage::disk('public')->exists($order->file_path)) {
            Storage::disk('public')->delete($order->file_path);
        }
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan dihapus.');
    }

    public function download(Order $order)
    {
        abort_unless(Storage::disk('public')->exists($order->file_path), 404);
        return Storage::disk('public')->download($order->file_path, $order->file_name);
    }
}
