@extends('admin.layout')
@section('page-title', 'Kelola Pesanan')
@section('page-sub', 'Total: '.$orders->total().' pesanan')

@section('content')
<form method="GET" class="flex flex-wrap gap-3 mb-6">
    <input name="search" value="{{ request('search') }}" placeholder="Cari kode / nama / HP" class="input rounded-xl px-3 py-2.5 flex-1 min-w-64" data-testid="orders-search">
    <select name="status" class="input rounded-xl px-3 py-2.5" data-testid="orders-filter">
        <option value="">Semua Status</option>
        @foreach(['pending','proses','selesai','dibatalkan'] as $s)
        <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button class="btn-primary rounded-xl px-6">Filter</button>
</form>

<div class="glass rounded-2xl overflow-hidden">
    <table class="w-full data text-sm">
        <thead><tr>
            <th class="text-left">Kode</th><th class="text-left">Tanggal</th><th class="text-left">Pelanggan</th>
            <th class="text-left">Layanan</th><th class="text-left">Hal×Rkp</th><th class="text-left">Total</th>
            <th class="text-left">Status</th><th></th>
        </tr></thead>
        <tbody>
        @forelse($orders as $o)
        <tr data-testid="order-row-{{ $o->id }}">
            <td class="font-mono text-ice-300">{{ $o->order_code }}</td>
            <td class="text-white/70">{{ $o->created_at->format('d/m/y H:i') }}</td>
            <td>
                <div class="text-white">{{ $o->customer_name }}</div>
                <div class="text-xs text-white/40">{{ $o->customer_phone }}</div>
            </td>
            <td>{{ $o->serviceLabel() }}</td>
            <td class="font-mono">{{ $o->pages }}×{{ $o->copies }}</td>
            <td class="font-mono">Rp{{ number_format($o->total_price,0,',','.') }}</td>
            <td><span class="text-xs px-2 py-1 rounded-full border {{ $o->statusColor() }}">{{ $o->status }}</span></td>
            <td class="text-right">
                <a href="{{ route('admin.orders.show', $o) }}" class="text-ice-300 text-xs hover:underline" data-testid="view-order-{{ $o->id }}">Kelola</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center text-white/40 py-12">Tidak ada pesanan</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $orders->links() }}</div>
@endsection
