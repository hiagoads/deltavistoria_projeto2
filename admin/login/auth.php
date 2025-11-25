<?php
/**
 * Processamento do Login - Delta Vistoria
 * Rota separada: /admin/login/
 */
session_start();
require_once '../../includes/config.php'; // CORREÇÃO: ../../

// Redireciona se já estiver logado
if (isset($_SESSION['usuario'])) {
    header('Location: ../'); // Vai para /admin/
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    
    // Validações básicas
    if (empty($email) || empty($senha)) {
        $_SESSION['erro'] = "Por favor, preencha todos os campos.";
        header('Location: index.php');
        exit;
    }
    
    try {
        // Buscar usuário no banco (apenas admins ativos)
        $sql = "SELECT * FROM usuarios WHERE email = ? AND ativo = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
        
        // Verificação simplificada - senha fixa
        if ($usuario && $senha === 'senha123') {
            // Login bem-sucedido
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'email' => $usuario['email'],
                'nome' => $usuario['nome']
            ];
            
            // Registrar log de acesso
            $log_sql = "INSERT INTO logs_acesso (usuario_id, ip, user_agent) VALUES (?, ?, ?)";
            $log_stmt = $pdo->prepare($log_sql);
            $log_stmt->execute([
                $usuario['id'],
                $_SERVER['REMOTE_ADDR'],
                $_SERVER['HTTP_USER_AGENT']
            ]);
            
            // Redirecionar para admin
            header('Location: ../');
            exit;
            
        } else {
            $_SESSION['erro'] = "E-mail ou senha incorretos. Use: senha123";
            header('Location: index.php');
            exit;
        }
        
    } catch (PDOException $e) {
        $_SESSION['erro'] = "Erro interno do sistema. Tente novamente mais tarde.";
        header('Location: index.php');
        exit;
    }
}

header('Location: index.php');
exit;
?>