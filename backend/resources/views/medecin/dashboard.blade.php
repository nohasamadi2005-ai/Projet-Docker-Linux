<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Médecin</title>
    <style>
        body { font-family:Arial,sans-serif; background:#f0f4f8; }
        nav { background:#48bb78; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        nav .brand { color:white; font-size:18px; font-weight:bold; }
        .logout-btn { background:rgba(255,255,255,0.2); color:white; border:none; padding:8px 16px; border-radius:8px; cursor:pointer; }
        .container { max-width:800px; margin:2rem auto; padding:0 1rem; }
        .card { background:white; border-radius:16px; padding:2rem; box-shadow:0 4px 20px rgba(0,0,0,0.1); text-align:center; }
    </style>
</head>
<body>
<nav>
    <div class="brand">🏥 Cabinet Médical</div>
    <div>
        <span style="color:white;margin-right:1rem">Dr. {{ auth()->user()->nom }}</span>
        <form action="/logout" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="logout-btn">Déconnexion</button>
        </form>
    </div>
</nav>
<div class="container">
    <div class="card">
<h2>Bienvenue Dr. {{ auth()->user()->nom }} ! 👨‍⚕️</h2>
        <p>Vous êtes connecté en tant que <strong>Médecin</strong></p>
    </div>
</div>
</body>
</html>