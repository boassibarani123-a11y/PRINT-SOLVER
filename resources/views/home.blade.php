@extends('layouts.base')

@section('body')
<nav class="border-b border-white/5 sticky top-0 z-30 bg-[#05070a]/70 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-ice-300 text-black grid place-items-center font-black text-lg shadow-lg shadow-ice-500/30">P</div>
            <div>
                <div class="font-display font-bold tracking-tight text-lg text-white leading-none">{{ $settings['business_name'] ?? 'PRINT SOLVER' }}</div>
                <div class="text-xs text-ice-300/60 mt-0.5">{{ $settings['business_tagline'] ?? '' }}</div>
            </div>
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('order.track') }}" class="hidden sm:inline-block px-4 py-2 rounded-full btn-ghost text-sm">Lacak Pesanan</a>
            <a href="{{ route('admin.login') }}" class="px-4 py-2 rounded-full btn-primary text-sm">Login Admin</a>
        </div>
    </div>
</nav>

<section class="max-w-7xl mx-auto px-6 pt-16 pb-12">
    <div class="grid lg:grid-cols-12 gap-10 items-center">
        <div class="lg:col-span-7">
            <span class="badge-ice rounded-full text-xs px-3 py-1 uppercase tracking-widest">Layanan Cetak Profesional</span>
            <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-bold mt-6 leading-[1.02] text-white">
                Print <span class="italic text-ice-300">apa saja,</span><br>
                bayar <span class="text-ice-300">seadanya</span> halaman.
            </h1>
            <p class="text-white/60 mt-6 max-w-xl text-lg">
                Upload dokumenmu, pilih layanan, dan sistem akan otomatis menghitung halaman & total biaya. Cepat, transparan, tanpa antre.
            </p>
            <div class="grid grid-cols-3 gap-3 mt-10 max-w-lg" data-testid="price-cards">
                <div class="glass rounded-2xl p-4">
                    <div class="text-xs text-ice-300/80 uppercase tracking-widest">Hitam Putih</div>
                    <div class="font-display text-3xl font-bold text-white mt-1">Rp{{ number_format($settings['price_bw'] ?? 500, 0, ',', '.') }}</div>
                    <div class="text-xs text-white/50">/ lembar</div>
                </div>
                <div class="glass rounded-2xl p-4 !border-ice-300/50">
                    <div class="text-xs text-ice-300 uppercase tracking-widest">Berwarna</div>
                    <div class="font-display text-3xl font-bold text-white mt-1">Rp{{ number_format($settings['price_color'] ?? 1000, 0, ',', '.') }}</div>
                    <div class="text-xs text-white/50">/ lembar</div>
                </div>
                <div class="glass rounded-2xl p-4">
                    <div class="text-xs text-ice-300/80 uppercase tracking-widest">Booklet</div>
                    <div class="font-display text-3xl font-bold text-white mt-1">Rp{{ number_format($settings['price_booklet'] ?? 800, 0, ',', '.') }}</div>
                    <div class="text-xs text-white/50">/ lembar</div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5">
            <div class="glass glass-hover rounded-3xl p-8 relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-ice-400/20 blur-3xl rounded-full"></div>
                <h2 class="font-display text-2xl font-bold text-white">Formulir Pemesanan</h2>
                <p class="text-white/50 text-sm mt-1">Isi data & upload file. Estimasi harga muncul otomatis.</p>

                <form method="POST" action="{{ route('order.store') }}" enctype="multipart/form-data" class="mt-6 space-y-4" id="order-form" data-testid="order-form">
                    @csrf

                    @if ($errors->any())
                    <div class="rounded-xl border border-rose-500/40 bg-rose-500/10 text-rose-200 text-sm p-3" data-testid="form-errors">
                        <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs uppercase tracking-widest text-ice-300/70">Nama</label>
                            <input required name="customer_name" value="{{ old('customer_name') }}" class="input w-full mt-1 rounded-xl px-3 py-2.5" placeholder="Nama lengkap" data-testid="input-name">
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-widest text-ice-300/70">No. HP</label>
                            <input required name="customer_phone" value="{{ old('customer_phone') }}" class="input w-full mt-1 rounded-xl px-3 py-2.5" placeholder="0812..." data-testid="input-phone">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-widest text-ice-300/70">Email (opsional)</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="input w-full mt-1 rounded-xl px-3 py-2.5" placeholder="email@contoh.com" data-testid="input-email">
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-widest text-ice-300/70">Alamat (opsional)</label>
                        <textarea name="customer_address" rows="2" class="input w-full mt-1 rounded-xl px-3 py-2.5" placeholder="Alamat pengambilan/kirim" data-testid="input-address">{{ old('customer_address') }}</textarea>
                    </div>

                    <div>
                        <label class="text-xs uppercase tracking-widest text-ice-300/70">Layanan</label>
                        <div class="grid grid-cols-3 gap-2 mt-2" data-testid="service-picker">
                            @php
                                $services = [
                                    'bw' => ['label' => 'Hitam Putih', 'price' => $settings['price_bw'] ?? 500],
                                    'color' => ['label' => 'Berwarna', 'price' => $settings['price_color'] ?? 1000],
                                    'booklet' => ['label' => 'Booklet', 'price' => $settings['price_booklet'] ?? 800],
                                ];
                            @endphp
                            @foreach($services as $key => $s)
                            <label class="cursor-pointer">
                                <input type="radio" name="service_type" value="{{ $key }}" class="hidden peer" {{ $key==='bw' ? 'checked' : '' }} data-price="{{ $s['price'] }}" data-testid="service-{{ $key }}">
                                <div class="rounded-xl border border-white/10 p-3 text-center peer-checked:border-ice-300 peer-checked:bg-ice-300/10 transition">
                                    <div class="text-xs text-white/60">{{ $s['label'] }}</div>
                                    <div class="font-bold text-white mt-1">Rp{{ number_format($s['price'],0,',','.') }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="text-xs uppercase tracking-widest text-ice-300/70">Upload File</label>
                        <label class="mt-1 flex items-center justify-center rounded-xl border-2 border-dashed border-ice-300/30 hover:border-ice-300 bg-black/30 px-4 py-6 cursor-pointer transition" for="file-input">
                            <div class="text-center">
                                <div class="text-ice-300 font-semibold" id="file-label">Klik atau seret file ke sini</div>
                                <div class="text-xs text-white/40 mt-1">PDF (otomatis hitung halaman) · docx · gambar · dll — max 50MB</div>
                            </div>
                        </label>
                        <input id="file-input" type="file" name="file" class="hidden" required data-testid="input-file">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs uppercase tracking-widest text-ice-300/70">Jumlah Halaman</label>
                            <input required min="1" type="number" name="pages" id="pages" value="{{ old('pages', 1) }}" class="input w-full mt-1 rounded-xl px-3 py-2.5" data-testid="input-pages">
                            <div class="text-[10px] text-ice-300/60 mt-1" id="pages-hint">PDF akan terhitung otomatis</div>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-widest text-ice-300/70">Jumlah Rangkap</label>
                            <input required min="1" type="number" name="copies" id="copies" value="{{ old('copies', 1) }}" class="input w-full mt-1 rounded-xl px-3 py-2.5" data-testid="input-copies">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs uppercase tracking-widest text-ice-300/70">Catatan (opsional)</label>
                        <textarea name="notes" rows="2" class="input w-full mt-1 rounded-xl px-3 py-2.5" placeholder="Contoh: cetak 2 sisi, jilid spiral, dll" data-testid="input-notes">{{ old('notes') }}</textarea>
                    </div>

                    <div class="rounded-2xl border border-ice-300/30 bg-ice-300/5 p-4 flex items-center justify-between">
                        <div>
                            <div class="text-xs uppercase tracking-widest text-ice-300/80">Estimasi Total</div>
                            <div class="font-display text-3xl font-bold text-white mt-1" id="total-price" data-testid="total-price">Rp0</div>
                        </div>
                        <div class="text-right text-xs text-white/50 leading-relaxed">
                            <div>Harga/lembar: <span id="ppp-display" class="text-ice-300 font-mono">Rp500</span></div>
                            <div>Halaman × Rangkap</div>
                        </div>
                    </div>

                    <button type="submit" class="w-full btn-primary rounded-full py-3 font-display font-bold text-base tracking-wide" data-testid="submit-order">Kirim Pesanan →</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-16 border-t border-white/5">
    <div class="grid md:grid-cols-3 gap-6">
        <div class="glass rounded-2xl p-6">
            <div class="text-ice-300 font-mono text-sm">01</div>
            <h3 class="font-display text-xl font-bold text-white mt-2">Upload & Hitung Otomatis</h3>
            <p class="text-white/50 text-sm mt-2">Upload file PDF-mu dan sistem akan menghitung jumlah halaman secara otomatis.</p>
        </div>
        <div class="glass rounded-2xl p-6">
            <div class="text-ice-300 font-mono text-sm">02</div>
            <h3 class="font-display text-xl font-bold text-white mt-2">Harga Transparan</h3>
            <p class="text-white/50 text-sm mt-2">Total biaya dihitung real-time berdasarkan layanan, halaman, dan rangkap.</p>
        </div>
        <div class="glass rounded-2xl p-6">
            <div class="text-ice-300 font-mono text-sm">03</div>
            <h3 class="font-display text-xl font-bold text-white mt-2">Lacak Pesanan</h3>
            <p class="text-white/50 text-sm mt-2">Setelah kirim, kamu dapat kode pesanan untuk melacak status kapan saja.</p>
        </div>
    </div>
</section>

<footer class="border-t border-white/5 mt-8">
    <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col sm:flex-row justify-between items-center text-sm text-white/40">
        <div>© {{ date('Y') }} {{ $settings['business_name'] ?? 'PRINT SOLVER' }}. Semua hak dilindungi.</div>
        <div>{{ $settings['business_phone'] ?? '' }} · {{ $settings['business_address'] ?? '' }}</div>
    </div>
</footer>

@push('scripts')
<script>
const priceMap = {
    color:   {{ (int)($settings['price_color'] ?? 1000) }},
    bw:      {{ (int)($settings['price_bw'] ?? 500) }},
    booklet: {{ (int)($settings['price_booklet'] ?? 800) }},
};
const fmt = n => 'Rp' + Math.round(n).toLocaleString('id-ID');
const pages = document.getElementById('pages');
const copies = document.getElementById('copies');
const total = document.getElementById('total-price');
const ppp = document.getElementById('ppp-display');
const fileInput = document.getElementById('file-input');
const fileLabel = document.getElementById('file-label');
const pagesHint = document.getElementById('pages-hint');

function selectedService() {
    const r = document.querySelector('input[name="service_type"]:checked');
    return r ? r.value : 'bw';
}
function updateTotal() {
    const s = selectedService();
    const p = priceMap[s] || 0;
    const t = p * (parseInt(pages.value)||0) * (parseInt(copies.value)||0);
    total.textContent = fmt(t);
    ppp.textContent = fmt(p);
}
document.querySelectorAll('input[name="service_type"]').forEach(r => r.addEventListener('change', updateTotal));
[pages, copies].forEach(el => el.addEventListener('input', updateTotal));

fileInput.addEventListener('change', async () => {
    const f = fileInput.files[0];
    if (!f) return;
    fileLabel.textContent = f.name;
    if (f.type === 'application/pdf' || f.name.toLowerCase().endsWith('.pdf')) {
        pagesHint.textContent = 'Menghitung halaman PDF...';
        const fd = new FormData(); fd.append('file', f);
        try {
            const res = await fetch("{{ route('order.count-pdf') }}", {
                method:'POST',
                headers:{'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept':'application/json'},
                body: fd
            });
            const j = await res.json();
            if (j.pages) {
                pages.value = j.pages;
                pagesHint.textContent = `✓ Terdeteksi ${j.pages} halaman`;
                updateTotal();
            } else {
                pagesHint.textContent = j.error || 'Silakan input jumlah halaman manual';
            }
        } catch (e) {
            pagesHint.textContent = 'Gagal auto-hitung, input manual';
        }
    } else {
        pagesHint.textContent = 'File non-PDF — silakan input halaman manual';
    }
});

updateTotal();
</script>
@endpush
@endsection
