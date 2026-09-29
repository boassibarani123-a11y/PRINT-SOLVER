@extends('layouts.base')

@section('title', 'Login Admin')

@section('body')
<div class="min-h-screen grid place-items-center px-6">
    <div class="w-full max-w-md">
        <div class="text-center mb-6">
            <div class="mx-auto w-14 h-14 rounded-2xl bg-ice-300 text-black grid place-items-center font-black text-2xl">P</div>
            <h1 class="font-display text-3xl font-bold text-white mt-4">Admin Dashboard</h1>
            <p class="text-white/50 text-sm mt-1">Masuk untuk mengelola pesanan & keuangan</p>
        </div>
        <div class="glass rounded-3xl p-8">
            @if($errors->any())
            <div class="rounded-xl border border-rose-500/40 bg-rose-500/10 text-rose-200 text-sm p-3 mb-4" data-testid="login-error">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs uppercase tracking-widest text-ice-300/70">Email</label>
                    <input required name="email" type="email" value="{{ old('email','admin@printsolver.test') }}" class="input w-full mt-1 rounded-xl px-3 py-2.5" data-testid="login-email">
                </div>
                <div>
                    <label class="text-xs uppercase tracking-widest text-ice-300/70">Password</label>
                    <input required name="password" type="password" class="input w-full mt-1 rounded-xl px-3 py-2.5" data-testid="login-password">
                </div>
                <label class="flex items-center gap-2 text-sm text-white/60">
                    <input type="checkbox" name="remember"> Ingat saya
                </label>
                <button class="btn-primary w-full rounded-xl py-2.5 font-semibold" data-testid="login-submit">Masuk</button>
            </form>
            <div class="text-center mt-6 text-xs text-white/40">
                Default: admin@printsolver.test / admin123
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-ice-300/70 text-sm hover:text-ice-300">← Kembali ke situs</a>
        </div>
    </div>
</div>
@endsection
