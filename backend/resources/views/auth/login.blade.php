<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Cabinet Médical</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
        }

        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo h1 {
            font-size: 24px;
            color: #4299e1;
        }

        .logo p {
            font-size: 13px;
            color: #718096;
            margin-top: 4px;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #2d3748;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            font-size: 14px;
            color: #4a5568;
            margin-bottom: 6px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
            outline: none;
        }

        input:focus {
            border-color: #4299e1;
        }

        .btn {
            width: 100%;
            padding: 13px;
            background: #4299e1;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background 0.2s;
        }

        .btn:hover { background: #3182ce; }

        .error {
            background: #fff5f5;
            color: #e53e3e;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 14px;
            border-left: 4px solid #e53e3e;
        }

        .link {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 14px;
            color: #718096;
        }

        .link a {
            color: #4299e1;
            text-decoration: none;
            font-weight: 500;
        }

        .link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="card">

    <div class="logo">
        <h1>🏥 Cabinet Médical</h1>
        <p>Système de rendez-vous en ligne</p>
    </div>

    <h2>Connexion</h2>

    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form action="/login" method="POST">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Votre email" required />
        </div>

        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="Votre mot de passe" required />
        </div>

        <button type="submit" class="btn">Se connecter</button>
    </form>

    <p class="link">Pas encore inscrit ? <a href="/register">S'inscrire</a></p>
</div>
</body>
</html>