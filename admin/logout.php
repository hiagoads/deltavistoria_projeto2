<?php
/**
 * Logout - Delta Vistoria
 * Encerra a sessão do administrador
 */
session_start();

// Registrar log de logout se usuário estiver logado
if (isset($_SESSION['usuario'])) {
    require_once '../includes/config.php';
    
    try {
        // Registrar hora do logout
        $sql = "UPDATE logs_acesso SET logout_em = NOW() 
                WHERE usuario_id = ? AND logout_em IS NULL 
                ORDER BY acesso_em DESC LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['usuario']['id']]);
    } catch (PDOException $e) {
        error_log("Erro ao registrar logout: " . $e->getMessage());
    }
}

// Destruir sessão completamente
session_destroy();

// Redirecionar para login
header('Location: login/');
exit;
?>