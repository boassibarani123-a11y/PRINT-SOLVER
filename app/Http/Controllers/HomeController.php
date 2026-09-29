<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser as PdfParser;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'settings' => Setting::all_map(),
        ]);
    }

    public function priceEstimate(Request $request)
    {
        $request->validate([
            'service_type' => 'required|in:color,bw,booklet',
            'pages'        => 'required|integer|min:1',
            'copies'       => 'required|integer|min:1',
        ]);

        $priceMap = [
            'color'   => (int) Setting::get('price_color', 1000),
            'bw'      => (int) Setting::get('price_bw', 500),
            'booklet' => (int) Setting::get('price_booklet', 800),
        ];

        $ppp = $priceMap[$request->service_type];
        $total = $ppp * (int) $request->pages * (int) $request->copies;

        return response()->json([
            'price_per_page' => $ppp,
            'total_price'    => $total,
        ]);
    }

    public function countPdfPages(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:51200',
        ]);

        try {
            $parser = new PdfParser();
            $pdf = $parser->parseFile($request->file('file')->getRealPath());
            $pages = count($pdf->getPages());
            return response()->json(['pages' => max(1, $pages)]);
        } catch (\Throwable $e) {
            return response()->json(['pages' => null, 'error' => 'Gagal membaca PDF, silakan input jumlah halaman manual.'], 200);
        }
    }

    public function storeOrder(Request $request)
    {
        $data = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:30',
            'customer_email'   => 'nullable|email|max:255',
            'customer_address' => 'nullable|string|max:500',
            'service_type'     => 'required|in:color,bw,booklet',
            'pages'            => 'required|integer|min:1|max:5000',
            'copies'           => 'required|integer|min:1|max:1000',
            'notes'            => 'nullable|string|max:1000',
            'file'             => 'required|file|max:51200|mimes:pdf,doc,docx,jpg,jpeg,png,ppt,pptx,xls,xlsx',
        ]);

        $priceMap = [
            'color'   => (int) Setting::get('price_color', 1000),
            'bw'      => (int) Setting::get('price_bw', 500),
            'booklet' => (int) Setting::get('price_booklet', 800),
        ];
        $ppp = $priceMap[$data['service_type']];
        $total = $ppp * (int) $data['pages'] * (int) $data['copies'];

        $file = $request->file('file');
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('orders', $filename, 'public');

        $order = Order::create([
            'order_code'       => 'PS-' . strtoupper(Str::random(8)),
            'customer_name'    => $data['customer_name'],
            'customer_phone'   => $data['customer_phone'],
            'customer_email'   => $data['customer_email'] ?? null,
            'customer_address' => $data['customer_address'] ?? null,
            'service_type'     => $data['service_type'],
            'file_name'        => $file->getClientOriginalName(),
            'file_path'        => $path,
            'pages'            => $data['pages'],
            'copies'           => $data['copies'],
            'price_per_page'   => $ppp,
            'total_price'      => $total,
            'notes'            => $data['notes'] ?? null,
            'status'           => 'pending',
        ]);

        return redirect()->route('order.success', $order->order_code);
    }

    public function orderSuccess(string $code)
    {
        $order = Order::where('order_code', $code)->firstOrFail();
        return view('order-success', [
            'order' => $order,
            'settings' => Setting::all_map(),
        ]);
    }

    public function trackForm()
    {
        return view('track', ['settings' => Setting::all_map(), 'order' => null]);
    }

    public function trackFind(Request $request)
    {
        $request->validate(['order_code' => 'required|string']);
        $order = Order::where('order_code', $request->order_code)->first();
        return view('track', ['settings' => Setting::all_map(), 'order' => $order, 'searched' => true]);
    }
}
