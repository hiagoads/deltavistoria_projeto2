<?php
/**
 * Sistema de Autenticação - Delta Vistoria
 * Apenas para administradores
 */

require_once 'config.php';

/**
 * Verifica se o usuário está logado
 * Redireciona para login se não estiver autenticado
 */
function verificaAdmin() {
    if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
        $_SESSION['erro'] = "Acesso restrito. Faça login como administrador.";
        header('Location: /delta_vistoria/admin/login/');
        exit;
    }
    return $_SESSION['usuario'];
}

/**
 * Verifica se já está logado (para redirecionar do login)
 */
function redirecionaSeLogado() {
    if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {
        header('Location: /delta_vistoria/admin/');
        exit;
    }
}

/**
 * Destroi a sessão e faz logout
 */
function logout() {
    session_destroy();
    header('Location: /delta_vistoria/admin/login/');
    exit;
}
?>