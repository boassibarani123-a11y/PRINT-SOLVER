@php
    $current = request()->route()->getName();
    $nav = [
        ['admin.dashboard', 'Dashboard', 'M3 12l2-2m0 0l7-7 7 7m-9 2v8'],
        ['admin.orders.index', 'Pesanan', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['admin.prices', 'Harga & Toko', 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1'],
        ['admin.expenses.index', 'Pengeluaran', 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z'],
        ['admin.reports', 'Laporan', 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2z'],
        ['admin.account', 'Akun', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
    ];
@endphp
<aside class="w-64 bg-black/70 border-r border-white/5 min-h-screen p-6 sticky top-0" data-testid="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 mb-10">
        <div class="w-10 h-10 rounded-xl bg-ice-300 text-black grid place-items-center font-black">P</div>
        <div>
            <div class="font-display font-bold text-white leading-none">Print Solver</div>
            <div class="text-[10px] uppercase tracking-widest text-ice-300/60 mt-1">Admin Panel</div>
        </div>
    </a>
    <nav class="space-y-1">
        @foreach($nav as [$route, $label, $icon])
        <a href="{{ route($route) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition
            {{ str_starts_with($current, $route) ? 'bg-ice-300/10 text-white border border-ice-300/30' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
            data-testid="nav-{{ $route }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
            {{ $label }}
        </a>
        @endforeach
    </nav>

    <form method="POST" action="{{ route('admin.logout') }}" class="mt-10">
        @csrf
        <button class="w-full text-left px-3 py-2 rounded-xl text-rose-300/80 hover:text-rose-200 hover:bg-rose-500/10 text-sm" data-testid="admin-logout">Keluar</button>
    </form>
</aside>
