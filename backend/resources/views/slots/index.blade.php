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
        .logout-btn { background:rgba(255,255,255,0.2); color:white; border:none; padding:8px 16px; border-radius:8px; cursor:pointer; font-size:14px; margin-left:1rem; }
        .container { max-width:900px; margin:2rem auto; padding:0 1rem; }
        h2 { font-size:22px; color:#2d3748; margin-bottom:1.5rem; }
        .alert-success { background:#d1fae5; color:#065f46; padding:.75rem; border-radius:8px; margin-bottom:1rem; }
        .alert-danger  { background:#fef2f2; color:#dc2626; padding:.75rem; border-radius:8px; margin-bottom:1rem; }
        .add-form { background:white; border-radius:10px; padding:1.5rem; margin-bottom:2rem; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
        .add-form h3 { font-size:16px; color:#2d3748; margin-bottom:1rem; }
        .form-row { display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:.75rem; align-items:end; }
        .form-group { display:flex; flex-direction:column; gap:.3rem; }
        .form-group label { font-size:12px; color:#718096; font-weight:500; }
        .form-group input { padding:.5rem .75rem; border:1px solid #e2e8f0; border-radius:6px; font-size:13px; outline:none; }
        .form-group input:focus { border-color:#4299e1; }
        .btn-add { padding:.55rem 1.25rem; background:#4299e1; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px; white-space:nowrap; }
        .btn-add:hover { background:#3182ce; }
        table { width:100%; border-collapse:collapse; background:white; border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
        th { background:#f7fafc; padding:.75rem 1rem; text-align:left; font-size:13px; color:#718096; border-bottom:1px solid #e2e8f0; }
        td { padding:.75rem 1rem; border-bottom:1px solid #f7fafc; font-size:13px; color:#2d3748; }
        .badge-disponible { background:#d1fae5; color:#065f46; padding:.2rem .6rem; border-radius:20px; font-size:11px; font-weight:500; }
        .badge-reserve    { background:#fef2f2; color:#dc2626; padding:.2rem .6rem; border-radius:20px; font-size:11px; font-weight:500; }
        .btn-del { padding:.25rem .6rem; border:1px solid #e2e8f0; border-radius:4px; color:#718096; background:transparent; cursor:pointer; font-size:11px; }
        .btn-del:hover { border-color:#dc2626; color:#dc2626; }
    </style>
</head>
<body>
<nav>
    <div class="brand">🏥 Cabinet Médical — Médecin</div>
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
    <h2>Gestion des créneaux</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="add-form">
        <h3>Ajouter un créneau</h3>
        <form method="POST" action="/medecin/creneaux">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date_creneau" required/>
                </div>
                <div class="form-group">
                    <label>Heure début</label>
                    <input type="time" name="heure_debut" required/>
                </div>
                <div class="form-group">
                    <label>Heure fin</label>
                    <input type="time" name="heure_fin" required/>
                </div>
                <button type="submit" class="btn-add">+ Ajouter</button>
            </div>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($slots as $slot)
            <tr>
                <td>{{ \Carbon\Carbon::parse($slot->date_creneau)->format('d/m/Y') }}</td>
                <td>{{ $slot->heure_debut }}</td>
                <td>{{ $slot->heure_fin }}</td>
                <td>
                    @if($slot->disponible)
                        <span class="badge-disponible">Disponible</span>
                    @else
                        <span class="badge-reserve">Réservé</span>
                    @endif
                </td>
                <td>
                    <form method="POST" action="/medecin/creneaux/{{ $slot->id }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-del"
                                onclick="return confirm('Supprimer ce créneau ?')">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#718096;padding:2rem">
                        Aucun créneau créé pour le moment.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>