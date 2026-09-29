@extends('layouts.base')

@section('body')
<div class="max-w-3xl mx-auto px-6 py-20">
    <div class="glass rounded-3xl p-10 text-center relative overflow-hidden">
        <div class="absolute -top-32 -left-24 w-72 h-72 bg-ice-400/20 blur-3xl rounded-full"></div>
        <div class="relative">
            <div class="mx-auto w-16 h-16 rounded-full bg-ice-300 text-black grid place-items-center text-3xl font-black">✓</div>
            <h1 class="font-display text-4xl font-bold text-white mt-6">Pesanan Diterima!</h1>
            <p class="text-white/60 mt-2">Simpan kode pesanan di bawah untuk melacak status.</p>

            <div class="mt-8 inline-block px-8 py-5 rounded-2xl bg-black border border-ice-300/40" data-testid="order-code-display">
                <div class="text-xs uppercase tracking-widest text-ice-300">Kode Pesanan</div>
                <div class="font-mono text-3xl font-bold text-white mt-1">{{ $order->order_code }}</div>
            </div>

            <div class="mt-8 text-left grid sm:grid-cols-2 gap-4">
                <div class="rounded-xl border border-white/10 p-4">
                    <div class="text-xs uppercase text-ice-300/70">Layanan</div>
                    <div class="text-white font-semibold mt-1">{{ $order->serviceLabel() }}</div>
                </div>
                <div class="rounded-xl border border-white/10 p-4">
                    <div class="text-xs uppercase text-ice-300/70">Halaman × Rangkap</div>
                    <div class="text-white font-semibold mt-1">{{ $order->pages }} × {{ $order->copies }}</div>
                </div>
                <div class="rounded-xl border border-white/10 p-4">
                    <div class="text-xs uppercase text-ice-300/70">Total</div>
                    <div class="text-ice-300 font-bold text-xl mt-1">Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
                </div>
                <div class="rounded-xl border border-white/10 p-4">
                    <div class="text-xs uppercase text-ice-300/70">Status</div>
                    <div class="mt-1"><span class="text-xs px-2 py-1 rounded-full border {{ $order->statusColor() }}">{{ ucfirst($order->status) }}</span></div>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('order.track') }}" class="btn-ghost px-5 py-2.5 rounded-full">Lacak Pesanan</a>
                <a href="{{ route('home') }}" class="btn-primary px-5 py-2.5 rounded-full">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
