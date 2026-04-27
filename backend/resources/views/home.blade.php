<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil — Cabinet Médical</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; background:#f0f4f8; }

        nav {
            background: #4299e1;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .brand { color:white; font-size:18px; font-weight:bold; }

        nav .user-info { display:flex; align-items:center; gap:1rem; }

        nav .user-name { color:white; font-size:14px; }

        .badge {
            background: white;
            color: #4299e1;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .logout-btn:hover { background: rgba(255,255,255,0.3); }

        .container {
            max-width: 600px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .welcome-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .welcome-card .icon { font-size: 60px; margin-bottom: 1rem; }

        .welcome-card h2 {
            font-size: 24px;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .welcome-card p {
            color: #718096;
            font-size: 15px;
        }

        .role-badge {
            display: inline-block;
            margin-top: 1rem;
            padding: 6px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .role-patient  { background:#ebf8ff; color:#2b6cb0; }
        .role-medecin  { background:#f0fff4; color:#276749; }
    </style>
</head>
<body>

<nav>
    <div class="brand">🏥 Cabinet Médical</div>
    <div class="user-info">
        <span class="user-name">{{ auth()->user()->nom }}</span>
        <span class="badge">{{ auth()->user()->role }}</span>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="container">
    <div class="welcome-card">
        @if(auth()->user()->role === 'medecin')
            <div class="icon">👨‍⚕️</div>
            <h2>Bienvenue Dr. {{ auth()->user()->nom }} !</h2>
            <p>Vous êtes connecté en tant que médecin.</p>
            <span class="role-badge role-medecin">Médecin</span>
        @else
            <div class="icon">🧑‍⚕️</div>
            <h2>Bienvenue {{ auth()->user()->nom }} !</h2>
            <p>Vous êtes connecté en tant que patient.</p>
            <span class="role-badge role-patient">Patient</span>
        @endif
    </div>
</div>

</body>
</html>