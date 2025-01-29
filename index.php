<?php

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet Biblio - Portfolio</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour plus d'icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .section-title {
            border-left: 5px solid #0d6efd;
            padding-left: 1rem;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        <!-- En-tête -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">📖 Projet Biblio</h1>
            <p class="lead text-muted">Gestion de Bibliothèque Full-Stack</p>
        </div>

        <!-- Contexte -->
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <h2 class="section-title mb-4">🌟 Contexte</h2>
                <p class="lead">Application web pour l'apprentissage des concepts CRUD</p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-database text-primary me-2"></i>
                            <span>Opérations CRUD</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            <span>Sécurité optimale</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-paint-brush text-primary me-2"></i>
                            <span>UI simple avec Bootstrap</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technologies -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="section-title mb-4">🛠️ Technologies Utilisées</h2>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Frontend</h5>
                        <p class="card-text">HTML5 • CSS3 • Bootstrap 5</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Backend</h5>
                        <p class="card-text">PHP natif • Sessions utilisateur</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Base de données</h5>
                        <p class="card-text">MySQL • Architecture relationnelle</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fonctionnalités -->
        <div class="mb-5">
            <h2 class="section-title mb-4">🔥 Fonctionnalités</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">🚪 Authentification</h5>
                            <p class="card-text">Inscription/connexion sécurisée avec hachage</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">📚 Gestion des Livres</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Ajout détaillé</li>
                                <li><i class="fas fa-check text-success me-2"></i>Édition en temps réel</li>
                                <li><i class="fas fa-check text-success me-2"></i>Filtres dynamiques</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">🛡️ Sécurité</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Protection CSRF</li>
                                <li><i class="fas fa-check text-success me-2"></i>Protection XSS</li>
                                <li><i class="fas fa-check text-success me-2"></i>Protection SQL Injection</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Apprentissages -->
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <h2 class="section-title mb-4">📈 Apprentissages Clés</h2>
                <div class="row g-4">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fas fa-code text-primary me-2"></i>
                                Développement Full-Stack sans frameworks
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-database text-primary me-2"></i>
                                Optimisation des performances SQL
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fas fa-server text-primary me-2"></i>
                                Gestion des états avec sessions PHP
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-bug text-primary me-2"></i>
                                Débogage avancé (XAMPP • DevTools)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Démo -->
        <div class="text-center">
            <a href="login.php" class="btn btn-primary btn-lg">
                <i class="fas fa-external-link-alt me-2"></i>Voir le projet
            </a>
        </div>
    </div>

    <!-- Bootstrap JS et Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>