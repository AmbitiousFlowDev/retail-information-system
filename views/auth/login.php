<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Système d'Information</title>
    
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    
    <script src="https://kit.fontawesome.com/4645065950.js" crossorigin="anonymous"></script>
    <style>
        @import url('../../public/css/mookup.css');
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row login-section">
        
        <div class="col-lg-6 d-flex align-items-center justify-content-center left-panel">
            <div style="width: 100%; max-width: 450px;">
                
                <h2 class="fw-bold mb-2">Connexion</h2>
                <p class="text-muted mb-4">Bienvenue ! Veuillez vous connecter à votre compte</p>

                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?controller=Auth&action=login" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label text-secondary fw-bold small">Nom utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Entrez votre nom utilisateur" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-secondary fw-bold small">Mot de passe</label>
                        <div class="input-group">
                            <input type="password" class="form-control password-input" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                            <span class="input-group-text border-start-0" onclick="togglePassword()">
                                <i class="fa-regular fa-eye text-muted" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label text-secondary small" for="rememberMe">
                                Se souvenir de moi
                            </label>
                        </div>
                        <a href="#" class="text-primary text-decoration-none small">Mot de passe oublié ?</a>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>

                    <div class="text-center">
                        <span class="text-muted small">Vous n'avez pas de compte ?</span>
                        <a href="#" class="text-primary text-decoration-none small fw-bold">Créer un compte</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6 d-none d-lg-flex flex-column align-items-center justify-content-center right-panel">
            
            <div style="max-width: 480px;">
                <div class="mb-4">
                    <div class="brand-icon">
                        <i class="fa-solid fa-chart-simple text-white"></i>
                    </div>
                </div>

                <h2 class="fw-bold mb-3">Système d'Information</h2>
                <p class="mb-5 text-light opacity-75 fs-5">
                    Gérez efficacement votre distribution avec notre plateforme complète
                </p>

                <ul class="list-unstyled feature-list">
                    <li>
                        <span class="check-icon"><i class="fa-solid fa-check"></i></span>
                        <span>Gestion des clients et commandes</span>
                    </li>
                    <li>
                        <span class="check-icon"><i class="fa-solid fa-check"></i></span>
                        <span>Suivi des stocks en temps réel</span>
                    </li>
                    <li>
                        <span class="check-icon"><i class="fa-solid fa-check"></i></span>
                        <span>Tableaux de bord analytiques</span>
                    </li>
                </ul>
            </div>

            <div class="help-icon">
                <i class="fa-solid fa-question"></i>
            </div>
        </div>

    </div>
</div>

<script src="../../public/js/bootstrap.min.js"></script>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>