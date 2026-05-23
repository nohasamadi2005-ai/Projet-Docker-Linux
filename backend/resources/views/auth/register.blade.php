<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Cabinet Médical</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; background:linear-gradient(135deg,#667eea,#764ba2); display:flex; justify-content:center; align-items:center; min-height:100vh; }
        .card { background:white; padding:2.5rem; border-radius:16px; box-shadow:0 20px 60px rgba(0,0,0,0.2); width:100%; max-width:420px; }
        .logo { text-align:center; margin-bottom:1.5rem; }
        .logo h1 { font-size:24px; color:#4299e1; }
        .logo p { font-size:13px; color:#718096; margin-top:4px; }
        h2 { text-align:center; margin-bottom:1.5rem; color:#2d3748; font-size:20px; }
        .form-group { margin-bottom:1.2rem; }
        label { display:block; font-size:14px; color:#4a5568; margin-bottom:6px; font-weight:500; }
        input { width:100%; padding:12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px; outline:none; }
        input:focus { border-color:#4299e1; }
        .role-group { display:flex; gap:12px; }
        .role-option { flex:1; border:2px solid #e2e8f0; border-radius:10px; padding:12px; text-align:center; cursor:pointer; transition:all 0.2s; }
        .role-option input[type="radio"] { display:none; }
        .role-option.selected { border-color:#4299e1; background:#ebf8ff; }
        .role-option .icon { font-size:24px; margin-bottom:4px; }
        .role-option .label { font-size:13px; font-weight:500; color:#4a5568; }
        .btn { width:100%; padding:13px; background:#4299e1; color:white; border:none; border-radius:8px; font-size:16px; cursor:pointer; margin-top:0.5rem; }
        .btn:hover { background:#3182ce; }
        .error { background:#fff5f5; color:#e53e3e; padding:12px; border-radius:8px; margin-bottom:1rem; font-size:14px; border-left:4px solid #e53e3e; }
        .link { text-align:center; margin-top:1.2rem; font-size:14px; color:#718096; }
        .link a { color:#4299e1; text-decoration:none; font-weight:500; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">
        <h1>🏥 Cabinet Médical</h1>
        <p>Système de rendez-vous en ligne</p>
    </div>
    <h2>Inscription</h2>

    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form action="/register" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom complet</label>
            <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Votre nom complet" required />
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Votre email" required />
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="Minimum 6 caractères" required />
        </div>
        <div class="form-group">
            <label>Confirmer mot de passe</label>
            <input type="password" name="password_confirmation" placeholder="Confirmer" required />
        </div>
        <div class="form-group">
            <label>Je suis :</label>
            <div class="role-group">
                <label class="role-option selected" id="opt-patient">
                    <input type="radio" name="role" value="patient" checked />
                    <div class="icon">🧑‍⚕️</div>
                    <div class="label">Patient</div>
                </label>
                <label class="role-option" id="opt-medecin">
                    <input type="radio" name="role" value="medecin" />
                    <div class="icon">👨‍⚕️</div>
                    <div class="label">Médecin</div>
                </label>
            </div>
        </div>
        <button type="submit" class="btn">S'inscrire</button>
    </form>

    <p class="link">Déjà inscrit ? <a href="/login">Se connecter</a></p>
</div>

<script>
    document.getElementById('opt-patient').addEventListener('click', function() {
        document.getElementById('opt-patient').classList.add('selected');
        document.getElementById('opt-medecin').classList.remove('selected');
    });
    document.getElementById('opt-medecin').addEventListener('click', function() {
        document.getElementById('opt-medecin').classList.add('selected');
        document.getElementById('opt-patient').classList.remove('selected');
    });
</script>
</body>
</html>