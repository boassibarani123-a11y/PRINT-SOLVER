@extends('admin.layout')
@section('page-title', 'Laporan Keuangan')
@section('page-sub', 'Periode: '.date('d M Y', strtotime($from)).' — '.date('d M Y', strtotime($to)))

@section('content')
<form method="GET" class="glass rounded-2xl p-5 flex flex-wrap items-end gap-3 mb-6">
    <div>
        <label class="text-xs uppercase text-ice-300/70">Dari</label>
        <input type="date" name="from" value="{{ $from }}" class="input rounded-xl px-3 py-2.5 mt-1">
    </div>
    <div>
        <label class="text-xs uppercase text-ice-300/70">Sampai</label>
        <input type="date" name="to" value="{{ $to }}" class="input rounded-xl px-3 py-2.5 mt-1">
    </div>
    <button class="btn-primary rounded-xl px-6 py-2.5 font-semibold">Terapkan</button>
</form>

<div class="grid md:grid-cols-4 gap-5">
    <div class="glass rounded-2xl p-6"><div class="text-xs uppercase text-ice-300/70">Pesanan Selesai</div><div class="font-display text-3xl font-bold text-white mt-2">{{ $orderCount }}</div></div>
    <div class="glass rounded-2xl p-6"><div class="text-xs uppercase text-ice-300/70">Pemasukan</div><div class="font-display text-2xl font-bold text-white mt-2">Rp{{ number_format($revenue,0,',','.') }}</div></div>
    <div class="glass rounded-2xl p-6"><div class="text-xs uppercase text-ice-300/70">Pengeluaran</div><div class="font-display text-2xl font-bold text-white mt-2">Rp{{ number_format($expense,0,',','.') }}</div></div>
    <div class="glass rounded-2xl p-6 !border-ice-300/40"><div class="text-xs uppercase text-ice-300">Keuntungan Bersih</div><div class="font-display text-2xl font-bold {{ $profit>=0?'text-ice-300':'text-rose-300' }} mt-2">Rp{{ number_format($profit,0,',','.') }}</div></div>
</div>

<div class="glass rounded-2xl p-6 mt-6">
    <h3 class="font-display font-bold text-white text-lg">Rincian per Layanan</h3>
    <table class="w-full data text-sm mt-4">
        <thead><tr><th class="text-left">Layanan</th><th class="text-left">Jumlah Pesanan</th><th class="text-left">Total Pemasukan</th></tr></thead>
        <tbody>
        @forelse($breakdown as $b)
        <tr>
            <td class="text-white">{{ match($b->service_type){'color'=>'Berwarna','bw'=>'Hitam Putih','booklet'=>'Booklet',default=>$b->service_type} }}</td>
            <td class="font-mono">{{ $b->jml }}</td>
            <td class="font-mono text-ice-300">Rp{{ number_format($b->total,0,',','.') }}</td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-center text-white/40 py-8">Tidak ada data pada periode ini</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
