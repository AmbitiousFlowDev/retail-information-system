<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — SI Grande Distribution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .brand-logo {
            font-weight: 700;
            color: #0d6efd;
            letter-spacing: -1px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="card login-card p-1 border border-dark">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="brand-logo mb-1">STOCK MANAGER</h2>
                        <p class="text-muted small">Système d'Information — Grande Distribution</p>
                    </div>

                    <h4 class="card-title mb-4">Connexion</h4>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger py-2 small" role="alert">
                            Identifiants invalides. Veuillez réessayer.
                        </div>
                    <?php endif; ?>

                    <form action="index.php?action=login" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control" id="floatingInput"
                                placeholder="Nom d'utilisateur" required autofocus>
                            <label for="floatingInput">Nom d'utilisateur</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="floatingPassword"
                                placeholder="Mot de passe" required>
                            <label for="floatingPassword">Mot de passe</label>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                            <label class="form-check-label text-muted small" for="rememberMe">
                                Se souvenir de moi
                            </label>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg shadow-sm" type="submit">
                                Se connecter
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-transparent border-0 text-center pb-3">
                    <p class="text-muted small mb-0">&copy; 2026 SI Grande Distribution</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>