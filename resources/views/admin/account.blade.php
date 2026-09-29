@extends('admin.layout')
@section('page-title', 'Akun Admin')
@section('page-sub', 'Perbarui profil dan password')

@section('content')
<form method="POST" action="{{ route('admin.account.update') }}" class="glass rounded-2xl p-6 space-y-4 max-w-xl" data-testid="account-form">
    @csrf
    <div>
        <label class="text-xs uppercase text-ice-300/70">Nama</label>
        <input required name="name" value="{{ old('name', $user->name) }}" class="input w-full mt-1 rounded-xl px-3 py-2.5">
    </div>
    <div>
        <label class="text-xs uppercase text-ice-300/70">Email</label>
        <input required type="email" name="email" value="{{ old('email', $user->email) }}" class="input w-full mt-1 rounded-xl px-3 py-2.5">
    </div>
    <hr class="border-white/10">
    <div class="text-white/60 text-sm">Ubah password (kosongkan jika tidak ingin mengubah)</div>
    <div>
        <label class="text-xs uppercase text-ice-300/70">Password Saat Ini</label>
        <input type="password" name="current_password" class="input w-full mt-1 rounded-xl px-3 py-2.5">
    </div>
    <div>
        <label class="text-xs uppercase text-ice-300/70">Password Baru</label>
        <input type="password" name="password" class="input w-full mt-1 rounded-xl px-3 py-2.5">
    </div>
    <div>
        <label class="text-xs uppercase text-ice-300/70">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="input w-full mt-1 rounded-xl px-3 py-2.5">
    </div>
    <button class="btn-primary rounded-full px-8 py-3 font-semibold" data-testid="save-account">Simpan Perubahan</button>
</form>
@endsection
