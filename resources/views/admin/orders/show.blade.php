@extends('admin.layout')
@section('page-title', 'Pesanan '.$order->order_code)
@section('page-sub', $order->created_at->format('d M Y, H:i'))

@section('content')
<div class="grid lg:grid-cols-3 gap-5">
    <div class="glass rounded-2xl p-6 lg:col-span-2">
        <h3 class="font-display font-bold text-white text-lg">Detail Pesanan</h3>
        <div class="grid sm:grid-cols-2 gap-4 mt-6">
            <div><div class="text-xs uppercase text-ice-300/70">Nama</div><div class="text-white mt-1">{{ $order->customer_name }}</div></div>
            <div><div class="text-xs uppercase text-ice-300/70">HP</div><div class="text-white mt-1">{{ $order->customer_phone }}</div></div>
            <div><div class="text-xs uppercase text-ice-300/70">Email</div><div class="text-white mt-1">{{ $order->customer_email ?? '-' }}</div></div>
            <div><div class="text-xs uppercase text-ice-300/70">Alamat</div><div class="text-white mt-1">{{ $order->customer_address ?? '-' }}</div></div>
            <div><div class="text-xs uppercase text-ice-300/70">Layanan</div><div class="text-white mt-1">{{ $order->serviceLabel() }}</div></div>
            <div><div class="text-xs uppercase text-ice-300/70">Harga/Lembar</div><div class="text-white mt-1 font-mono">Rp{{ number_format($order->price_per_page,0,',','.') }}</div></div>
            <div><div class="text-xs uppercase text-ice-300/70">Halaman</div><div class="text-white mt-1">{{ $order->pages }}</div></div>
            <div><div class="text-xs uppercase text-ice-300/70">Rangkap</div><div class="text-white mt-1">{{ $order->copies }}</div></div>
            <div class="sm:col-span-2"><div class="text-xs uppercase text-ice-300/70">Catatan</div><div class="text-white mt-1">{{ $order->notes ?? '-' }}</div></div>
        </div>
        <div class="mt-6 pt-6 border-t border-white/5 flex flex-wrap items-center justify-between gap-3">
            <div>
                <div class="text-xs uppercase text-ice-300/70">Total</div>
                <div class="font-display text-3xl font-bold text-ice-300">Rp{{ number_format($order->total_price,0,',','.') }}</div>
            </div>
            <a href="{{ route('admin.orders.download', $order) }}" class="btn-ghost px-5 py-2.5 rounded-full text-sm" data-testid="download-file">↓ Download File ({{ $order->file_name }})</a>
        </div>
    </div>

    <div class="space-y-5">
        <div class="glass rounded-2xl p-6">
            <h3 class="font-display font-bold text-white text-lg">Ubah Status</h3>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="mt-4 space-y-3">
                @csrf @method('PATCH')
                <select name="status" class="input w-full rounded-xl px-3 py-2.5" data-testid="status-select">
                    @foreach(['pending','proses','selesai','dibatalkan'] as $s)
                    <option value="{{ $s }}" @selected($order->status===$s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="btn-primary w-full rounded-xl py-2.5 font-semibold" data-testid="update-status">Perbarui Status</button>
            </form>
            <div class="mt-4">
                <span class="text-xs uppercase text-ice-300/70">Saat ini:</span>
                <span class="text-xs px-2 py-1 rounded-full border {{ $order->statusColor() }} ml-2">{{ $order->status }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Hapus pesanan ini?')">
            @csrf @method('DELETE')
            <button class="w-full rounded-xl py-2.5 border border-rose-500/40 bg-rose-500/10 text-rose-200 hover:bg-rose-500/20 text-sm" data-testid="delete-order">Hapus Pesanan</button>
        </form>

        <a href="{{ route('admin.orders.index') }}" class="block text-center text-ice-300/70 hover:text-ice-300 text-sm">← Kembali ke daftar</a>
    </div>
</div>
@endsection
