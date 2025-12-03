<?php
/**
 * Cabeçalho Universal - Delta Vistoria
 */

function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
                $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $project = '/deltavistoria_projeto2';
    $url = $protocol . $host . $project;
    return rtrim($url, '/');
}

$base_url = getBaseUrl();
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
        if (isset($titulo_pagina)) {
            echo htmlspecialchars($titulo_pagina) . ' - Delta Vistoria';
        } else {
            echo 'Delta Vistoria - Sistema de Vistoria de Veículos';
        }
        ?>
    </title>

    <link rel="stylesheet" href="/deltavistoria_projeto2/css/menu.css">
    <link rel="stylesheet" href="/deltavistoria_projeto2/css/style.css">
    
    <link rel="stylesheet" href="/deltavistoria_projeto2/css/principal.css">
    <link rel="stylesheet" href="/deltavistoria_projeto2/css/contato.css">
    
    <?php if (strpos($_SERVER['PHP_SELF'], '/admin/') !== false): ?>
        <link rel="stylesheet" href="/deltavistoria_projeto2/css/admin.css">
    <?php endif; ?>

    <link rel="stylesheet" href="/deltavistoria_projeto2/css/rodape.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="<?php echo $base_url; ?>/public/index.php" class="logo-link">
                    <img src="/deltavistoria_projeto2/img/logo_br.png" alt="Delta Vistoria Logo" class="logo-img">
                </a>
            </div>
            
            <button class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <nav class="nav-main" id="navMain">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <!-- Menu para admin logado -->
                    <ul class="nav-menu">
                        <li><a href="<?php echo $base_url; ?>/admin/index.php" class="<?php echo $pagina_atual == 'index.php' ? 'active' : ''; ?>">Dashboard</a></li>
                        <li><a href="<?php echo $base_url; ?>/admin/clientes-admin.php" class="<?php echo strpos($pagina_atual, 'clientes-') !== false ? 'active' : ''; ?>">Clientes</a></li>
                        <li><a href="<?php echo $base_url; ?>/admin/agendamentos-admin.php" class="<?php echo strpos($pagina_atual, 'agendamentos-') !== false ? 'active' : ''; ?>">Agendamentos</a></li>
                    </ul>
                    
                    <div class="user-area">
                        <span>Olá, <strong><?php echo htmlspecialchars($_SESSION['usuario']['nome'] ?? 'Admin'); ?></strong></span>
                        <a href="<?php echo $base_url; ?>/admin/logout.php" class="btn-logout" onclick="return confirm('Deseja sair?')">Sair</a>
                    </div>
                    
                <?php else: ?>
                    <!-- Menu para visitantes (site público) -->
                    <ul class="nav-menu">
                        <li><a href="<?php echo $base_url; ?>/public/index.php" class="<?php echo $pagina_atual == 'index.php' ? 'active' : ''; ?>">Início</a></li>
                        <li><a href="<?php echo $base_url; ?>/public/principal.php#quem-somos" class="<?php echo $pagina_atual == 'principal.php' ? 'active' : ''; ?>">Quem Somos</a></li>
                        <li><a href="<?php echo $base_url; ?>/public/contato.php" class="<?php echo $pagina_atual == 'contato.php' ? 'active' : ''; ?>">Contato</a></li>
                        <li><a href="<?php echo $base_url; ?>/public/agendamento.php" class="<?php echo $pagina_atual == 'agendamento.php' ? 'active' : ''; ?>">Solicitar Vistoria</a></li>
                    </ul>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <?php if (isset($_SESSION['sucesso'])): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($_SESSION['sucesso']); ?>
                    <?php unset($_SESSION['sucesso']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['erro'])): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($_SESSION['erro']); ?>
                    <?php unset($_SESSION['erro']); ?>
                </div>
            <?php endif; ?>

    <script>
        // Menu Mobile
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const navMain = document.getElementById('navMain');
            const navLinks = document.querySelectorAll('.nav-menu a');

            // Toggle menu ao clicar no hamburger
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navMain.classList.toggle('active');
            });

            // Fechar menu ao clicar em um link
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    navMain.classList.remove('active');
                });
            });

            // Fechar menu ao redimensionar a janela
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    hamburger.classList.remove('active');
                    navMain.classList.remove('active');
                }
            });
        });
    </script>