@extends('admin.layout')
@section('page-title', 'Harga & Informasi Toko')
@section('page-sub', 'Ubah harga layanan kapan saja')

@section('content')
<form method="POST" action="{{ route('admin.prices.update') }}" class="grid md:grid-cols-2 gap-5" data-testid="prices-form">
    @csrf

    <div class="glass rounded-2xl p-6">
        <h3 class="font-display font-bold text-white text-lg">Harga Layanan</h3>
        <p class="text-white/40 text-xs mt-1">Semua nilai per lembar (Rp)</p>
        <div class="space-y-4 mt-6">
            <div>
                <label class="text-xs uppercase tracking-widest text-ice-300/70">Print Hitam Putih</label>
                <input required type="number" step="0.01" name="price_bw" value="{{ $settings['price_bw'] ?? 500 }}" class="input w-full mt-1 rounded-xl px-3 py-2.5 font-mono" data-testid="input-price-bw">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest text-ice-300/70">Print Berwarna</label>
                <input required type="number" step="0.01" name="price_color" value="{{ $settings['price_color'] ?? 1000 }}" class="input w-full mt-1 rounded-xl px-3 py-2.5 font-mono" data-testid="input-price-color">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest text-ice-300/70">Booklet</label>
                <input required type="number" step="0.01" name="price_booklet" value="{{ $settings['price_booklet'] ?? 800 }}" class="input w-full mt-1 rounded-xl px-3 py-2.5 font-mono" data-testid="input-price-booklet">
            </div>
        </div>
    </div>

    <div class="glass rounded-2xl p-6">
        <h3 class="font-display font-bold text-white text-lg">Informasi Toko</h3>
        <div class="space-y-4 mt-6">
            <div>
                <label class="text-xs uppercase tracking-widest text-ice-300/70">Nama Bisnis</label>
                <input required name="business_name" value="{{ $settings['business_name'] ?? 'PRINT SOLVER' }}" class="input w-full mt-1 rounded-xl px-3 py-2.5">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest text-ice-300/70">Tagline</label>
                <input name="business_tagline" value="{{ $settings['business_tagline'] ?? '' }}" class="input w-full mt-1 rounded-xl px-3 py-2.5">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest text-ice-300/70">No. Telepon</label>
                <input name="business_phone" value="{{ $settings['business_phone'] ?? '' }}" class="input w-full mt-1 rounded-xl px-3 py-2.5">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest text-ice-300/70">Alamat</label>
                <textarea name="business_address" rows="2" class="input w-full mt-1 rounded-xl px-3 py-2.5">{{ $settings['business_address'] ?? '' }}</textarea>
            </div>
        </div>
    </div>

    <div class="md:col-span-2">
        <button class="btn-primary rounded-full px-8 py-3 font-semibold" data-testid="save-prices">Simpan Perubahan</button>
    </div>
</form>
@endsection
