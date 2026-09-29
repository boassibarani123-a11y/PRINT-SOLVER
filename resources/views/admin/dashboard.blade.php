@extends('admin.layout')
@section('page-title', 'Dashboard')
@section('page-sub', 'Ringkasan keuangan & aktivitas bulan ini')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="grid md:grid-cols-3 gap-5" data-testid="stats-cards">
    <div class="glass rounded-2xl p-6">
        <div class="text-xs uppercase tracking-widest text-ice-300/70">Pemasukan Bulan Ini</div>
        <div class="font-display text-3xl font-bold text-white mt-2" data-testid="stat-revenue">Rp{{ number_format($revenueMonth,0,',','.') }}</div>
        <div class="text-xs text-white/40 mt-1">Total sepanjang waktu: Rp{{ number_format($revenueAll,0,',','.') }}</div>
    </div>
    <div class="glass rounded-2xl p-6">
        <div class="text-xs uppercase tracking-widest text-ice-300/70">Pengeluaran Bulan Ini</div>
        <div class="font-display text-3xl font-bold text-white mt-2" data-testid="stat-expense">Rp{{ number_format($expenseMonth,0,',','.') }}</div>
        <div class="text-xs text-white/40 mt-1">Total: Rp{{ number_format($expenseAll,0,',','.') }}</div>
    </div>
    <div class="glass rounded-2xl p-6 !border-ice-300/30">
        <div class="text-xs uppercase tracking-widest text-ice-300">Keuntungan Bulan Ini</div>
        <div class="font-display text-3xl font-bold {{ $profitMonth>=0?'text-ice-300':'text-rose-300' }} mt-2" data-testid="stat-profit">Rp{{ number_format($profitMonth,0,',','.') }}</div>
        <div class="text-xs text-white/40 mt-1">Total: <span class="{{ $profitAll>=0?'text-ice-300':'text-rose-300' }}">Rp{{ number_format($profitAll,0,',','.') }}</span></div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-5 mt-6">
    <div class="glass rounded-2xl p-6 lg:col-span-2">
        <div class="flex justify-between items-start">
            <div>
                <div class="text-white font-display font-bold text-lg">Neraca 12 Bulan Terakhir</div>
                <div class="text-xs text-white/40">Pemasukan vs Pengeluaran</div>
            </div>
        </div>
        <div class="mt-4"><canvas id="chartFinance" height="120"></canvas></div>
    </div>

    <div class="glass rounded-2xl p-6">
        <div class="text-white font-display font-bold text-lg">Status Pesanan</div>
        <div class="mt-4 space-y-3">
            @foreach($statusCounts as $s => $c)
            <div class="flex items-center justify-between">
                <div class="text-sm text-white/70 capitalize">{{ $s }}</div>
                <div class="font-mono font-bold text-white">{{ $c }}</div>
            </div>
            <div class="h-1 bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-ice-300" style="width: {{ array_sum($statusCounts) ? ($c/array_sum($statusCounts)*100) : 0 }}%"></div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="glass rounded-2xl p-6 mt-6">
    <div class="flex justify-between items-center mb-4">
        <div class="text-white font-display font-bold text-lg">Pesanan Terbaru</div>
        <a href="{{ route('admin.orders.index') }}" class="text-xs text-ice-300 hover:underline">Lihat semua →</a>
    </div>
    <table class="w-full data text-sm">
        <thead><tr><th class="text-left">Kode</th><th class="text-left">Pelanggan</th><th class="text-left">Layanan</th><th class="text-left">Total</th><th class="text-left">Status</th><th></th></tr></thead>
        <tbody>
        @forelse($recentOrders as $o)
        <tr>
            <td class="font-mono text-ice-300">{{ $o->order_code }}</td>
            <td>{{ $o->customer_name }}</td>
            <td>{{ $o->serviceLabel() }}</td>
            <td class="font-mono">Rp{{ number_format($o->total_price,0,',','.') }}</td>
            <td><span class="text-xs px-2 py-1 rounded-full border {{ $o->statusColor() }}">{{ $o->status }}</span></td>
            <td class="text-right"><a href="{{ route('admin.orders.show', $o) }}" class="text-ice-300 text-xs hover:underline">Detail</a></td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-white/40 py-8">Belum ada pesanan</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
const ctx = document.getElementById('chartFinance');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($months),
        datasets: [
            { label: 'Pemasukan', data: @json($revenueSeries), backgroundColor: 'rgba(132,220,255,0.7)', borderRadius: 6 },
            { label: 'Pengeluaran', data: @json($expenseSeries), backgroundColor: 'rgba(255,255,255,0.15)', borderRadius: 6 },
        ]
    },
    options: {
        plugins: { legend: { labels: { color: '#bbecff' } } },
        scales: {
            x: { ticks: { color: '#bbecff88' }, grid: { color: 'rgba(255,255,255,0.04)' } },
            y: { ticks: { color: '#bbecff88', callback: v => 'Rp' + (v/1000) + 'k' }, grid: { color: 'rgba(255,255,255,0.04)' } }
        }
    }
});
</script>
@endpush
@endsection
