<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes RDV — Cabinet Médical</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; background:#f0f4f8; }
        nav { background:#4299e1; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        nav .brand { color:white; font-size:18px; font-weight:bold; }
        nav .links a { color:white; text-decoration:none; margin-left:1.5rem; font-size:14px; }
        .logout-btn { background:rgba(255,255,255,0.2); color:white; border:none; padding:8px 16px; border-radius:8px; cursor:pointer; font-size:14px; margin-left:1rem; }
        .container { max-width:800px; margin:2rem auto; padding:0 1rem; }
        h2 { font-size:22px; color:#2d3748; margin-bottom:1.5rem; }
        .alert-success { background:#d1fae5; color:#065f46; padding:.75rem; border-radius:8px; margin-bottom:1rem; }
        .rdv-card { background:white; border-radius:10px; padding:1rem 1.5rem; margin-bottom:1rem; display:flex; justify-content:space-between; align-items:center; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
        .rdv-date { font-weight:bold; color:#2d3748; }
        .rdv-time { color:#718096; font-size:13px; }
        .rdv-right { display:flex; align-items:center; gap:1rem; }
        .badge { display:inline-block; padding:.25rem .75rem; border-radius:20px; font-size:12px; font-weight:500; }
        .badge-en_attente { background:#fefcbf; color:#744210; }
        .badge-confirme   { background:#d1fae5; color:#065f46; }
        .badge-annule     { background:#fef2f2; color:#dc2626; }
        .btn-annuler { padding:.3rem .8rem; border:1px solid #dc2626; border-radius:6px; color:#dc2626; background:transparent; cursor:pointer; font-size:12px; }
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
    <h2>Mes Rendez-vous</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @forelse($appointments as $rdv)
        <div class="rdv-card">
            <div>
                <div class="rdv-date">
                    {{ \Carbon\Carbon::parse($rdv->creneau->date_creneau)->format('d/m/Y') }}
                </div>
                <div class="rdv-time">
                    {{ $rdv->creneau->heure_debut }} — {{ $rdv->creneau->heure_fin }}
                </div>
            </div>
            <div class="rdv-right">
                <span class="badge badge-{{ $rdv->statut }}">{{ $rdv->statut }}</span>
                @if($rdv->statut !== 'annule')
                    <form method="POST" action="/annuler/{{ $rdv->id }}">
                        @csrf
                        <button type="submit" class="btn-annuler"
                                onclick="return confirm('Confirmer l\'annulation ?')">
                            Annuler
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="empty">Aucun rendez-vous trouvé.</div>
    @endforelse
</div>
</body>
</html>