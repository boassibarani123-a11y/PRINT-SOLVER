<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        return view('admin.prices', [
            'settings' => Setting::all_map(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'price_color'       => 'required|numeric|min:0',
            'price_bw'          => 'required|numeric|min:0',
            'price_booklet'     => 'required|numeric|min:0',
            'business_name'     => 'required|string|max:100',
            'business_tagline'  => 'nullable|string|max:200',
            'business_phone'    => 'nullable|string|max:50',
            'business_address'  => 'nullable|string|max:300',
        ]);

        foreach ($data as $k => $v) {
            Setting::set($k, $v ?? '');
        }

        return redirect()->route('admin.prices')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
