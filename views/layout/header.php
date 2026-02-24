<?php
use Mgj\ProyectoBlog2025\Config\Parameters;
use Mgj\ProyectoBlog2025\Helpers\Authentication;

$baseUrl = Parameters::getBaseUrl();
?>     

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCAV - Gestión Académica</title>
    
    <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>assets/css/zebra_pagination.css" />
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/style.css?v=1.9">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="<?= $baseUrl ?>assets/js/main.js" defer></script>
</head>
<body>

<header class="main-header" style="background-color: #003366; color: white; padding: 10px 0; border-bottom: 4px solid #ffcc00;">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="<?= $baseUrl ?>assets/img/logoUcav.png" alt="Logo UCAV" style="height: 60px; margin-right: 20px;">
            <div class="header-titles">
                <h1 style="margin: 0; font-size: 1.4rem; font-weight: 700;">Universidad Católica de Ávila</h1>
                <p style="margin: 0; font-size: 0.85rem; color: #ffcc00; text-transform: uppercase; letter-spacing: 1px;">Gestión de Asistencias a Charlas</p>
            </div>
        </div>
        <div class="d-none d-md-block">
            <span class="badge rounded-pill bg-light text-dark shadow-sm p-2 px-3">
                <i class="far fa-calendar-alt me-1"></i> <?= date('d/m/Y') ?>
            </span>
        </div>
    </div>
</header>

<nav class="navbar" style="background-color: #002244; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
    <div class="container">
        <button class="menu-toggle" aria-label="Abrir menú" style="background: none; border: none; color: white; font-size: 1.5rem; display: none;">
            <i class="fas fa-bars"></i>
        </button>
        
        <ul class="nav-links d-flex align-items-center list-unstyled mb-0 w-100 justify-content-between">
            <div class="group-main d-flex">
                <?php if (Authentication::isUserLogged()): ?>
                    <li class="me-3">
                        <a href="<?= $baseUrl ?>index.php?controller=Asistencia&action=getAll" class="text-white text-decoration-none p-2 hover-link">
                            <i class="fas fa-clipboard-list me-1"></i> Asistencia
                        </a>
                    </li>
                    <li class="me-3">
                        <a href="<?= $baseUrl ?>index.php?controller=Charla&action=getAll" class="text-white text-decoration-none p-2 hover-link">
                            <i class="fas fa-microphone me-1"></i> Charlas
                        </a>
                    </li>
                <?php endif; ?>
            </div>

            <div class="group-auth d-flex align-items-center">
                <?php if (!Authentication::isUserLogged()): ?>
                    <li class="me-2">
                        <a href='<?= $baseUrl ?>index.php?controller=Usuario&action=showLogin' class="text-white text-decoration-none">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                    <li>
                        <a href='<?= $baseUrl ?>index.php?controller=Usuario&action=showRegister' class='btn btn-warning btn-sm fw-bold shadow-sm'>Registro</a>
                    </li>
                <?php else: ?>                                        
                    <li class='dropdown position-relative'>
                        <button class='btn btn-outline-light btn-sm dropdown-toggle' type="button" id='userMenuBtn'>
                            <i class="fas fa-user-circle me-1"></i>
                            <?= (isset($_SESSION["user"]->Nombre)) ? htmlspecialchars($_SESSION["user"]->Nombre) : "Usuario" ?>
                        </button>
                        
                        <ul class="dropdown-menu-custom shadow" id="userDropdown" style="display: none; position: absolute; right: 0; background: white; min-width: 160px; border-radius: 8px; list-style: none; padding: 10px; margin-top: 5px; z-index: 1000;">
                            <li>
                                <a href='<?= $baseUrl ?>index.php?controller=Usuario&action=showEditar' class="text-dark text-decoration-none d-block p-2">
                                    <i class="fas fa-user-edit me-2"></i>Mi Perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a href='<?= $baseUrl ?>index.php?controller=Usuario&action=closeSession' class='logout-link text-danger text-decoration-none d-block p-2'>
                                    <i class="fas fa-power-off me-2"></i>Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </div>
        </ul>
    </div>
</nav>

<div class="container mt-4">