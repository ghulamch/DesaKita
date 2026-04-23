<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalasi Portal Desa | Setup Wizard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="fixed inset-0 z-0 opacity-20" style="background-image: radial-gradient(#10b981 1px, transparent 1px); background-size: 30px 30px;"></div>
    
    <div class="w-full max-w-2xl relative z-10">
        <!-- Brand -->
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-emerald-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-emerald-200">
                <i class="bi bi-rocket-takeoff text-3xl"></i>
            </div>
            <h1 class="text-3xl font-black text-slate-800 font-display uppercase tracking-wider">Setup Wizard</h1>
            <p class="text-slate-500 font-medium">Instalasi Portal Desa Digital</p>
        </div>

        <div class="glass p-8 rounded-[2.5rem] shadow-2xl">
            @yield('content')
        </div>

        <div class="mt-8 text-center text-[10px] text-slate-400 font-black uppercase tracking-[0.2em]">
            &copy; {{ date('Y') }}
        </div>
    </div>
</body>
</html>
