<?php
/**
 * Cabeçalho Universal - Delta Vistoria
 * Header único para todo o sistema
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
        if (isset($titulo_pagina)) {
            echo $titulo_pagina . ' - Delta Vistoria';
        } else {
            echo 'Delta Vistoria - Sistema de Vistoria de Veículos';
        }
        ?>
    </title>
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
                        <li><a href="/delta_vistoria/admin/" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Dashboard</a></li>
                        <li><a href="/delta_vistoria/admin/clientes-admin.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'clientes-') !== false ? 'active' : ''; ?>">Clientes</a></li>
                        <li><a href="/delta_vistoria/admin/agendamentos-admin.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'agendamentos-') !== false ? 'active' : ''; ?>">Agendamentos</a></li>
                    </ul>
                    
                    <div class="user-area">
                        <span>Olá, <strong><?php echo $_SESSION['usuario']['nome']; ?></strong></span>
                        <a href="/delta_vistoria/admin/logout.php" class="btn-logout" onclick="return confirm('Deseja sair?')">Sair</a>
                    </div>
                    
                <?php else: ?>
                    <!-- Menu para visitantes (site público) -->
                    <ul class="nav-menu">
                        <li><a href="/delta_vistoria/public/index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Início</a></li>
                        <li><a href="/delta_vistoria/public/servicos.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'servicos.php' ? 'active' : ''; ?>">Serviços</a></li>
                        <li><a href="/delta_vistoria/public/quemsomos.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'quemsomos.php' ? 'active' : ''; ?>">Quem Somos</a></li>
                        <li><a href="/delta_vistoria/public/contato.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contato.php' ? 'active' : ''; ?>">Contato</a></li>
                        <li><a href="/delta_vistoria/public/agendamento.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'agendamento.php' ? 'active' : ''; ?>">Solicitar Vistoria</a></li>
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
                    <?php echo $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['erro'])): ?>
                <div class="alert alert-error">
                    <?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?>
                </div>
            <?php endif; ?>