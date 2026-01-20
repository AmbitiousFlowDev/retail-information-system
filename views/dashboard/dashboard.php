<?php 
// Retrieve user from session for the greeting
$user = $_SESSION['user'] ?? ['login' => 'Utilisateur'];
?>

<div class="d-flex" id="wrapper">

    <?php include_once 'views/layout/sidebar.php'; ?>

    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4">
            <div class="d-flex align-items-center justify-content-between w-100">
                <h4 class="m-0 text-secondary">Tableau de bord</h4>
                
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-circle-user me-1 text-primary"></i> 
                        <?= htmlspecialchars($user['login']) ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="index.php?controller=Auth&action=logout">Déconnexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid px-4 py-4">
            
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-primary h-100">
                        <div class="card-body">
                            <div class="text-muted small fw-bold text-uppercase">Chiffre d'Affaires</div>
                            <div class="fs-4 fw-bold text-dark mt-1">12,450 €</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-success h-100">
                        <div class="card-body">
                            <div class="text-muted small fw-bold text-uppercase">Commandes</div>
                            <div class="fs-4 fw-bold text-dark mt-1">45</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-warning h-100">
                        <div class="card-body">
                            <div class="text-muted small fw-bold text-uppercase">Clients</div>
                            <div class="fs-4 fw-bold text-dark mt-1">128</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-danger h-100">
                        <div class="card-body">
                            <div class="text-muted small fw-bold text-uppercase">Alertes Stock</div>
                            <div class="fs-4 fw-bold text-dark mt-1">3</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-5 text-center">
                    <img src="public/images/welcome_bg.svg" alt="" style="max-height: 150px; opacity: 0.8;" class="mb-3">
                    <h3>Bienvenue dans votre Système d'Information</h3>
                    <p class="text-muted">Sélectionnez un module dans le menu de gauche pour commencer.</p>
                </div>
            </div>

        </div>
    </div>
</div>