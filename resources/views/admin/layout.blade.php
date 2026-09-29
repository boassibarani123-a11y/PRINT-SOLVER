@extends('layouts.base')
@section('title', $title ?? 'Admin')

@section('body')
<div class="flex">
    @include('admin.partials.sidebar')
    <main class="flex-1 min-h-screen">
        <header class="border-b border-white/5 bg-black/40 backdrop-blur px-8 py-5 sticky top-0 z-20">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="font-display text-2xl font-bold text-white">@yield('page-title')</h1>
                    <div class="text-xs text-white/40 mt-1">@yield('page-sub')</div>
                </div>
                <div class="text-sm text-white/60">Halo, <span class="text-ice-300 font-semibold">{{ auth()->user()?->name }}</span></div>
            </div>
        </header>
        <div class="p-8">
            @if(session('success'))
            <div class="rounded-xl border border-emerald-500/40 bg-emerald-500/10 text-emerald-200 text-sm p-3 mb-6" data-testid="flash-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
            <div class="rounded-xl border border-rose-500/40 bg-rose-500/10 text-rose-200 text-sm p-3 mb-6">
                <ul class="list-disc ml-4">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
@endsection
