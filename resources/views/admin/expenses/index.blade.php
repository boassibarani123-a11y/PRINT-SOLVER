@extends('admin.layout')
@section('page-title', 'Pengeluaran')
@section('page-sub', 'Total pengeluaran: Rp'.number_format($total,0,',','.'))

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <form method="POST" action="{{ route('admin.expenses.store') }}" class="glass rounded-2xl p-6 space-y-4" data-testid="expense-form">
        @csrf
        <h3 class="font-display font-bold text-white text-lg">Tambah Pengeluaran</h3>
        <div>
            <label class="text-xs uppercase text-ice-300/70">Judul</label>
            <input required name="title" class="input w-full mt-1 rounded-xl px-3 py-2.5" data-testid="expense-title">
        </div>
        <div>
            <label class="text-xs uppercase text-ice-300/70">Jumlah (Rp)</label>
            <input required type="number" step="0.01" name="amount" class="input w-full mt-1 rounded-xl px-3 py-2.5 font-mono" data-testid="expense-amount">
        </div>
        <div>
            <label class="text-xs uppercase text-ice-300/70">Kategori</label>
            <select name="category" class="input w-full mt-1 rounded-xl px-3 py-2.5">
                @foreach(['operasional','tinta','kertas','listrik','gaji','lainnya'] as $c)
                <option value="{{ $c }}">{{ ucfirst($c) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs uppercase text-ice-300/70">Tanggal</label>
            <input required type="date" name="expense_date" value="{{ date('Y-m-d') }}" class="input w-full mt-1 rounded-xl px-3 py-2.5">
        </div>
        <div>
            <label class="text-xs uppercase text-ice-300/70">Deskripsi (opsional)</label>
            <textarea name="description" rows="2" class="input w-full mt-1 rounded-xl px-3 py-2.5"></textarea>
        </div>
        <button class="btn-primary w-full rounded-xl py-2.5 font-semibold" data-testid="save-expense">Simpan</button>
    </form>

    <div class="glass rounded-2xl overflow-hidden lg:col-span-2">
        <div class="p-4 border-b border-white/5">
            <h3 class="font-display font-bold text-white text-lg">Riwayat Pengeluaran</h3>
        </div>
        <table class="w-full data text-sm">
            <thead><tr><th class="text-left">Tanggal</th><th class="text-left">Judul</th><th class="text-left">Kategori</th><th class="text-left">Jumlah</th><th></th></tr></thead>
            <tbody>
            @forelse($expenses as $e)
            <tr>
                <td class="text-white/60">{{ $e->expense_date->format('d/m/y') }}</td>
                <td>
                    <div class="text-white">{{ $e->title }}</div>
                    @if($e->description)<div class="text-xs text-white/40">{{ $e->description }}</div>@endif
                </td>
                <td><span class="badge-ice text-xs px-2 py-1 rounded-full">{{ $e->category }}</span></td>
                <td class="font-mono text-rose-300">-Rp{{ number_format($e->amount,0,',','.') }}</td>
                <td class="text-right">
                    <form method="POST" action="{{ route('admin.expenses.destroy', $e) }}" onsubmit="return confirm('Hapus?')" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-rose-300/70 hover:text-rose-300 text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-white/40 py-12">Belum ada pengeluaran</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $expenses->links() }}</div>
    </div>
</div>
@endsection
