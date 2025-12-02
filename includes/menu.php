<?php
/**
 * Cabeçalho Universal - Delta Vistoria
 */

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$project_path = '/deltavistoria_projeto2';
$base_url = $protocol . "://" . $host . $project_path;

// Determinar a página atual para a classe 'active'
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
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <h1>Delta<span>Vistoria</span></h1>
            </div>
            
            <nav class="nav-main">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <!-- Menu para admin logado -->
                    <ul class="nav-menu">
                        <li><a href="<?php echo $base_url; ?>/admin/index.php" class="<?php echo $pagina_atual == 'index.php' ? 'active' : ''; ?>">Dashboard</a></li>
                        <li><a href="<?php echo $base_url; ?>/admin/clientes-admin.php" class="<?php echo strpos($pagina_atual, 'clientes-') !== false ? 'active' : ''; ?>">Clientes</a></li>
                        <li><a href="<?php echo $base_url; ?>/admin/agendamentos-admin.php" class="<?php echo strpos($pagina_atual, 'agendamentos-') !== false ? 'active' : ''; ?>">Agendamentos</a></li>
                    </ul>
                    
                    <div class="user-area">
                        <span>Olá, <strong><?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?></strong></span>
                        <a href="<?php echo $base_url; ?>/admin/logout.php" class="btn-logout" onclick="return confirm('Deseja sair?')">Sair</a>
                    </div>
                    
                <?php else: ?>
                    <!-- Menu para visitantes (site público) -->
                    <ul class="nav-menu">
                        <li><a href="<?php echo $base_url; ?>/public/index.php" class="<?php echo $pagina_atual == 'index.php' ? 'active' : ''; ?>">Início</a></li>
                        <li><a href="<?php echo $base_url; ?>/public/principal.php" class="<?php echo $pagina_atual == 'principal.php' ? 'active' : ''; ?>">Serviços</a></li>
                        <li><a href="<?php echo $base_url; ?>/public/principal.php" class="<?php echo $pagina_atual == 'principal.php' ? 'active' : ''; ?>">Quem Somos</a></li>
                        <li><a href="<?php echo $base_url; ?>/public/contato.php" class="<?php echo $pagina_atual == 'contato.php' ? 'active' : ''; ?>">Contato</a></li>
                        <li><a href="<?php echo $base_url; ?>/public/agendamento.php" class="<?php echo $pagina_atual == 'agendamento.php' ? 'active' : ''; ?>">Solicitar Vistoria</a></li>
                    </ul>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <!-- Área para mensagens de sistema -->
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