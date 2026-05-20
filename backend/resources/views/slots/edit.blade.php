<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un créneau — Cabinet Médical</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; background:#f0f4f8; }
        nav { background:#4299e1; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        nav .brand { color:white; font-size:18px; font-weight:bold; }
        nav .links a { color:white; text-decoration:none; margin-left:1.5rem; font-size:14px; }
        .logout-btn { background:rgba(255,255,255,0.2); color:white; border:none; padding:8px 16px; border-radius:8px; cursor:pointer; font-size:14px; margin-left:1rem; }
        .container { max-width:500px; margin:2rem auto; padding:0 1rem; }
        h2 { font-size:22px; color:#2d3748; margin-bottom:1.5rem; }
        .edit-form { background:white; border-radius:10px; padding:1.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
        .form-group { display:flex; flex-direction:column; gap:.3rem; margin-bottom:1rem; }
        .form-group label { font-size:12px; color:#718096; font-weight:500; }
        .form-group input { padding:.5rem .75rem; border:1px solid #e2e8f0; border-radius:6px; font-size:13px; outline:none; }
        .form-group input:focus { border-color:#4299e1; }
        .btn-save { padding:.6rem 1.5rem; background:#4299e1; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px; margin-right:.5rem; }
        .btn-cancel { padding:.6rem 1.5rem; background:white; color:#718096; border:1px solid #e2e8f0; border-radius:6px; cursor:pointer; font-size:13px; text-decoration:none; }
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
    <h2>Modifier le créneau</h2>

    @if($errors->any())
    <div style="
        background:#fef2f2;
        color:#dc2626;
        padding:.75rem;
        border-radius:8px;
        margin-bottom:1rem;
    ">
        {{ $errors->first() }}
    </div>
    @endif
    <div class="edit-form">
        <form method="POST" action="/medecin/creneaux/{{ $slot->id }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date_creneau"
                       value="{{ \Carbon\Carbon::parse($slot->date_creneau)->format('Y-m-d') }}"
                       required/>
            </div>
            <div class="form-group">
                <label>Heure début</label>
                <input type="time" name="heure_debut"
                       value="{{ $slot->heure_debut }}"
                       required/>
            </div>
            <div class="form-group">
                <label>Heure fin</label>
                <input type="time" name="heure_fin"
                       value="{{ $slot->heure_fin }}"
                       required/>
            </div>

            <div style="margin-top:1.5rem">
                <button type="submit" class="btn-save">Enregistrer</button>
                <a href="/medecin/creneaux" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>