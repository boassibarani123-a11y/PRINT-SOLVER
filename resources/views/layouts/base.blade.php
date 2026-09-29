<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Print Solver') · {{ \App\Models\Setting::get('business_name','PRINT SOLVER') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300..800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Bricolage Grotesque"', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        ice: {
                            50: '#f0fbff', 100: '#e0f7ff', 200: '#bbecff',
                            300: '#84dcff', 400: '#48c5f9', 500: '#1eabe7',
                            600: '#0e8bc6', 700: '#0e70a0', 800: '#125c83', 900: '#144d6d',
                        },
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Bricolage Grotesque', system-ui, sans-serif; background: #05070a; color: #e8f7ff; }
        .grid-bg {
            background-image:
                radial-gradient(circle at 20% 10%, rgba(72,197,249,0.10), transparent 40%),
                radial-gradient(circle at 80% 40%, rgba(72,197,249,0.06), transparent 45%),
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: auto, auto, 44px 44px, 44px 44px;
        }
        .glass { background: rgba(255,255,255,0.03); backdrop-filter: blur(14px); border:1px solid rgba(132,220,255,0.14); }
        .glass-hover:hover { border-color: rgba(132,220,255,0.35); box-shadow: 0 0 40px -10px rgba(72,197,249,.25); }
        .btn-primary { background:#84dcff; color:#05070a; font-weight:600; transition:.2s all; }
        .btn-primary:hover { background:#bbecff; transform: translateY(-1px); box-shadow: 0 10px 30px -10px rgba(132,220,255,.6); }
        .btn-ghost { border:1px solid rgba(132,220,255,0.25); color:#bbecff; transition:.2s all; }
        .btn-ghost:hover { border-color:#84dcff; background:rgba(132,220,255,0.06); }
        .input { background:rgba(10,15,22,.6); border:1px solid rgba(132,220,255,.15); color:#e8f7ff; }
        .input:focus { outline:none; border-color:#84dcff; box-shadow:0 0 0 4px rgba(132,220,255,.12); }
        .badge-ice { background: rgba(132,220,255,0.12); color:#bbecff; border:1px solid rgba(132,220,255,.3); }
        .noise::after {
            content:""; position: fixed; inset:0; pointer-events:none; z-index:0; opacity:.035;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }
        table.data th { text-transform:uppercase; letter-spacing:.08em; font-size:.72rem; color:#84dcff; }
        table.data td, table.data th { padding:.75rem 1rem; }
        table.data tbody tr { border-top: 1px solid rgba(132,220,255,.08); }
        table.data tbody tr:hover { background: rgba(132,220,255,.04); }
    </style>
    @stack('head')
</head>
<body class="min-h-screen grid-bg noise">
    <div class="relative z-10">
        @yield('body')
    </div>
    @stack('scripts')
</body>
</html>
