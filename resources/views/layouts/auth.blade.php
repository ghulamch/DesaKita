<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Authentication') | Digital Sejahtera</title>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.05) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .font-display { font-family: 'Outfit', sans-serif; }
        
        .lumina-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.05),
                0 10px 10px -5px rgba(0, 0, 0, 0.02);
            border-radius: 2rem;
        }

        .lumina-input {
            background: #f1f5f9;
            border: 2px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #1e293b;
            font-weight: 600;
        }

        .lumina-input:focus {
            background: white;
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .lumina-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
        }

        .lumina-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(16, 185, 129, 0.4);
        }

        .lumina-btn:active {
            transform: translateY(0);
        }

        .geometric-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.4;
            pointer-events: none;
        }
    </style>
</head>
<body class="antialiased p-6">
    <div class="geometric-bg" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zM6 34v-4h-2v4H0v2h4v4h2v-4h4v-2H6zM6 4v-4H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>

    <div class="w-full max-w-md">
        @yield('content')
    </div>
</body>
</html>
