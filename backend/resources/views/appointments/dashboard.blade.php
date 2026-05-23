<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard — Cabinet Médical</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; background:#f0f4f8; }
        nav { background:#4299e1; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        nav .brand { color:white; font-size:18px; font-weight:bold; }
        nav .links a { color:white; text-decoration:none; margin-left:1.5rem; font-size:14px; }
        .logout-btn { background:rgba(255,255,255,0.2); color:white; border:none; padding:8px 16px; border-radius:8px; cursor:pointer; font-size:14px; margin-left:1rem; }
        .container { max-width:1000px; margin:2rem auto; padding:0 1rem; }
        h2 { font-size:22px; color:#2d3748; margin-bottom:1.5rem; }
        .stats-row { display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem; }
        .stat-card { background:white; border-radius:10px; padding:1.25rem; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
        .stat-num { font-size:28px; font-weight:bold; }
        .stat-lbl { font-size:12px; color:#718096; margin-top:.25rem; }
        .stat-attente .stat-num { color:#744210; }
        .stat-confirme .stat-num { color:#065f46; }
        .stat-annule .stat-num  { color:#dc2626; }
        .alert-success { background:#d1fae5; color:#065f46; padding:.75rem; border-radius:8px; margin-bottom:1rem; }
        table { width:100%; border-collapse:collapse; background:white; border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
        th { background:#f7fafc; padding:.75rem 1rem; text-align:left; font-size:13px; color:#718096; border-bottom:1px solid #e2e8f0; }
        td { padding:.75rem 1rem; border-bottom:1px solid #f7fafc; font-size:13px; color:#2d3748; }
        .badge { display:inline-block; padding:.2rem .6rem; border-radius:20px; font-size:11px; font-weight:500; }
        .badge-en_attente { background:#fefcbf; color:#744210; }
        .badge-confirme   { background:#d1fae5; color:#065f46; }
        .badge-annule     { background:#fef2f2; color:#dc2626; }
        .btn-confirmer { padding:.25rem .6rem; background:#065f46; color:white; border:none; border-radius:4px; cursor:pointer; font-size:11px; margin-right:.3rem; }
        .btn-annuler { padding:.25rem .6rem; border:1px solid #dc2626; border-radius:4px; color:#dc2626; background:transparent; cursor:pointer; font-size:11px; }
    </style>
</head>
<body>
<nav>
    <div class="brand">🏥 Cabinet Médical — Admin</div>
    <div class="links">
        <a href="/medecin/dashboard">Dashboard</a>
        <a href="/medecin/creneaux">Créneaux</a>
        <form action="/logout" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="logout-btn">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="container">
    <h2>Dashboard</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="stats-row">
        <div class="stat-card stat-attente">
            <div class="stat-num">{{ $enAttente }}</div>
            <div class="stat-lbl">En attente</div>
        </div>
        <div class="stat-card stat-confirme">
            <div class="stat-num">{{ $confirmes }}</div>
            <div class="stat-lbl">Confirmés</div>
        </div>
        <div class="stat-card stat-annule">
            <div class="stat-num">{{ $annules }}</div>
            <div class="stat-lbl">Annulés</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $rdv)
            <tr>
                <td>{{ $rdv->patient->nom }}</td>
                <td>{{ \Carbon\Carbon::parse($rdv->creneau->date_creneau)->format('d/m/Y') }}</td>
                <td>{{ $rdv->creneau->heure_debut }} — {{ $rdv->creneau->heure_fin }}</td>
                <td><span class="badge badge-{{ $rdv->statut }}">{{ $rdv->statut }}</span></td>
                <td>
                    @if($rdv->statut === 'en_attente')
                        <form method="POST" action="/confirmer/{{ $rdv->id }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn-confirmer">Confirmer</button>
                        </form>
                    @endif
                    @if($rdv->statut !== 'annule')
                        <form method="POST" action="/annuler/{{ $rdv->id }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn-annuler">Annuler</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>