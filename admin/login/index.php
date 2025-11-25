<?php
/**
 * Página de Login - Delta Vistoria
 * Rota separada: /admin/login/
 */
$titulo_pagina = "Login Administrativo";
require_once '../../includes/topo.php'; // CORREÇÃO: ../../ para voltar 2 pastas

// Se usuário já está logado, redireciona
if (isset($_SESSION['usuario'])) {
    header('Location: ../'); // Vai para /admin/
    exit;
}
?>

<div class="main-content">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Login Administrativo</h1>
                <p>Área restrita para administradores</p>
            </div>

            <?php if (isset($_SESSION['erro'])): ?>
                <div class="alert alert-error">
                    <?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?>
                </div>
            <?php endif; ?>

            <form action="auth.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required autofocus>
                </div>

                <div class="form-group">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" id="senha" name="senha" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </form>

            <div class="login-footer">
                <p><a href="../../public/index.php">← Voltar para o site</a></p>
            </div>

            <div class="demo-accounts">
                <details>
                    <summary>Credenciais de Teste</summary>
                    <div class="demo-info">
                        <p><strong>Admin:</strong> admin@deltavistoria.com / senha123</p>
                        <p><strong>Gerente:</strong> gerente@deltavistoria.com / senha123</p>
                    </div>
                </details>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/rodape.php'; ?>