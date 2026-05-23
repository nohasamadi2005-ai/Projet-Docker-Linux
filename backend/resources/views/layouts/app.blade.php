<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f4f8; }
        .navbar {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
        }
        .navbar-brand { color: #1a56db; font-weight: bold; font-size: 1.2rem; }
        .navbar-links a {
            margin-left: 1rem;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .navbar-links a:hover { color: #1a56db; }
        .container { max-width: 900px; margin: 2rem auto; padding: 0 1rem; }
        .alert-success {
            background: #d1fae5; color: #065f46;
            padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem;
        }
        .alert-danger {
            background: #fef2f2; color: #dc2626;
            padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    @auth
    <nav class="navbar">
        <span class="navbar-brand">🏥 Cabinet Médical</span>
        <div class="navbar-links">
            @if(auth()->user()->role === 'patient')
                <a href="{{ route('appointments.index') }}">Créneaux</a>
                <a href="{{ route('appointments.mes-rdv') }}">Mes RDV</a>
            @else
                <a href="{{ route('appointments.dashboard') }}">Dashboard</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" style="background:none;border:none;color:#6b7280;cursor:pointer;">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>
    @endauth

    @yield('content')
</body>
</html>