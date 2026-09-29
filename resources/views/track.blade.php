@extends('layouts.base')

@section('body')
<nav class="border-b border-white/5">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-ice-300 text-black grid place-items-center font-black">P</div>
            <div class="font-display font-bold text-white">{{ $settings['business_name'] ?? 'PRINT SOLVER' }}</div>
        </a>
        <a href="{{ route('home') }}" class="btn-ghost px-4 py-2 rounded-full text-sm">← Beranda</a>
    </div>
</nav>

<div class="max-w-2xl mx-auto px-6 py-16">
    <h1 class="font-display text-4xl font-bold text-white">Lacak Pesanan</h1>
    <p class="text-white/60 mt-2">Masukkan kode pesanan untuk melihat status terkini.</p>

    <form method="POST" action="{{ route('order.track.find') }}" class="mt-8 flex gap-3">
        @csrf
        <input name="order_code" value="{{ request('order_code') }}" placeholder="PS-XXXXXXXX" required class="input flex-1 rounded-xl px-4 py-3 font-mono" data-testid="track-input">
        <button class="btn-primary rounded-xl px-6 font-semibold" data-testid="track-submit">Cari</button>
    </form>

    @if(!empty($searched))
        @if($order)
        <div class="glass rounded-2xl p-6 mt-8" data-testid="track-result">
            <div class="flex justify-between items-start flex-wrap gap-3">
                <div>
                    <div class="text-xs uppercase text-ice-300/70">Kode</div>
                    <div class="font-mono text-2xl font-bold text-white">{{ $order->order_code }}</div>
                </div>
                <span class="text-xs px-3 py-1.5 rounded-full border {{ $order->statusColor() }}">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="grid sm:grid-cols-2 gap-4 mt-6">
                <div><div class="text-xs text-ice-300/60 uppercase">Pelanggan</div><div class="text-white mt-1">{{ $order->customer_name }}</div></div>
                <div><div class="text-xs text-ice-300/60 uppercase">Layanan</div><div class="text-white mt-1">{{ $order->serviceLabel() }}</div></div>
                <div><div class="text-xs text-ice-300/60 uppercase">Halaman × Rangkap</div><div class="text-white mt-1">{{ $order->pages }} × {{ $order->copies }}</div></div>
                <div><div class="text-xs text-ice-300/60 uppercase">Total</div><div class="text-ice-300 font-bold mt-1">Rp{{ number_format($order->total_price,0,',','.') }}</div></div>
                <div><div class="text-xs text-ice-300/60 uppercase">Tanggal</div><div class="text-white mt-1">{{ $order->created_at->format('d M Y H:i') }}</div></div>
                <div><div class="text-xs text-ice-300/60 uppercase">File</div><div class="text-white mt-1 truncate">{{ $order->file_name }}</div></div>
            </div>
        </div>
        @else
        <div class="mt-8 p-6 rounded-2xl border border-rose-500/40 bg-rose-500/10 text-rose-200" data-testid="track-notfound">Pesanan tidak ditemukan. Periksa kembali kode pesanan Anda.</div>
        @endif
    @endif
</div>
@endsection
