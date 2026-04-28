<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créneaux — Cabinet Médical</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; background:#f0f4f8; }
        nav { background:#4299e1; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        nav .brand { color:white; font-size:18px; font-weight:bold; }
        nav .links a { color:white; text-decoration:none; margin-left:1.5rem; font-size:14px; }
        nav .links a:hover { text-decoration:underline; }
        .logout-btn { background:rgba(255,255,255,0.2); color:white; border:none; padding:8px 16px; border-radius:8px; cursor:pointer; font-size:14px; margin-left:1rem; }
        .container { max-width:900px; margin:2rem auto; padding:0 1rem; }
        h2 { font-size:22px; color:#2d3748; margin-bottom:.5rem; }
        .subtitle { color:#718096; font-size:14px; margin-bottom:1.5rem; }
        .alert-success { background:#d1fae5; color:#065f46; padding:.75rem; border-radius:8px; margin-bottom:1rem; }
        .alert-danger  { background:#fef2f2; color:#dc2626; padding:.75rem; border-radius:8px; margin-bottom:1rem; }
        .creneaux-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:1rem; margin-bottom:2rem; }
        .creneau-card { background:white; border:2px solid #68d391; border-radius:10px; padding:1rem; text-align:center; }
        .creneau-date { font-weight:bold; color:#2d3748; font-size:15px; }
        .creneau-time { color:#718096; font-size:13px; margin:.3rem 0; }
        .badge-disponible { display:inline-block; background:#d1fae5; color:#065f46; padding:.2rem .6rem; border-radius:20px; font-size:11px; margin-bottom:.75rem; }
        .btn-reserver { width:100%; padding:.5rem; background:#4299e1; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px; }
        .btn-reserver:hover { background:#3182ce; }
        .empty { text-align:center; color:#718096; padding:2rem; background:white; border-radius:10px; }
    </style>
</head>
<body>
<nav>
    <div class="brand">🏥 Cabinet Médical</div>
    <div class="links">
        <a href="/patient/accueil">Créneaux</a>
        <a href="/patient/mes-rdv">Mes RDV</a>
        <form action="/logout" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="logout-btn">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="container">
    <h2>Créneaux disponibles</h2>
    <p class="subtitle">Sélectionnez un créneau pour prendre rendez-vous</p>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-danger">{{ session('error') }}</div>
    @endif

    @if($creneaux->isEmpty())
        <div class="empty">Aucun créneau disponible pour le moment.</div>
    @else
        <div class="creneaux-grid">
            @foreach($creneaux as $creneau)
                <div class="creneau-card">
                    <div class="creneau-date">
                        {{ \Carbon\Carbon::parse($creneau->date_creneau)->format('d/m/Y') }}
                    </div>
                    <div class="creneau-time">
                        {{ $creneau->heure_debut }} — {{ $creneau->heure_fin }}
                    </div>
                    <span class="badge-disponible">Disponible</span>
                    <form method="POST" action="/reserver">
                        @csrf
                        <input type="hidden" name="creneau_id" value="{{ $creneau->id }}">
                        <button type="submit" class="btn-reserver">Réserver</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>