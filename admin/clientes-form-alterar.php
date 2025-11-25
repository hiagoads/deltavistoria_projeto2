<?php
/**
 * Formulário de Edição de Cliente - Área Administrativa
 * Versão corrigida para novo banco de dados
 */
$titulo_pagina = "Editar Cliente";
require_once 'config.inc.php';
require_once '../includes/topo.php';
require_once '../includes/menu.php';

// Verificar se o ID foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['erro'] = "Cliente não especificado.";
    header('Location: clientes-admin.php');
    exit;
}

$cliente_id = (int)$_GET['id'];

// Buscar dados do cliente - CORREÇÃO AQUI
try {
    $sql = "SELECT c.* FROM clientes c WHERE c.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cliente_id]);
    $cliente = $stmt->fetch();
    
    if (!$cliente) {
        $_SESSION['erro'] = "Cliente não encontrado.";
        header('Location: clientes-admin.php');
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['erro'] = "Erro ao carregar dados do cliente.";
    header('Location: clientes-admin.php');
    exit;
}
?>

<div class="main-content">
    <div class="page-header">
        <h1>Editar Cliente</h1>
        <p>Editando: <?php echo htmlspecialchars($cliente['nome']); ?></p>
    </div>

    <div class="content-card">
        <form action="clientes-alterar.php?action=editar&id=<?php echo $cliente_id; ?>" method="POST" id="form-cliente">
            <div class="form-section">
                <h3>Dados Pessoais</h3>
                
                <div class="form-group">
                    <label for="tipo_pessoa" class="form-label">Tipo de Pessoa *</label>
                    <select id="tipo_pessoa" name="tipo_pessoa" class="form-control" required>
                        <option value="PF" <?php echo $cliente['tipo_pessoa'] == 'PF' ? 'selected' : ''; ?>>Pessoa Física</option>
                        <option value="PJ" <?php echo $cliente['tipo_pessoa'] == 'PJ' ? 'selected' : ''; ?>>Pessoa Jurídica</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome" class="form-label">Nome Completo / Razão Social *</label>
                    <input type="text" id="nome" name="nome" class="form-control" 
                           value="<?php echo htmlspecialchars($cliente['nome']); ?>" required maxlength="150">
                </div>

                <div id="campo-cpf" class="form-group" style="display: <?php echo $cliente['tipo_pessoa'] == 'PF' ? 'block' : 'none'; ?>;">
                    <label for="cpf" class="form-label">CPF *</label>
                    <input type="text" id="cpf" name="cpf" class="form-control" 
                           value="<?php echo htmlspecialchars($cliente['cpf'] ?? ''); ?>" 
                           placeholder="000.000.000-00">
                </div>

                <div id="campo-cnpj" class="form-group" style="display: <?php echo $cliente['tipo_pessoa'] == 'PJ' ? 'block' : 'none'; ?>;">
                    <label for="cnpj" class="form-label">CNPJ *</label>
                    <input type="text" id="cnpj" name="cnpj" class="form-control" 
                           value="<?php echo htmlspecialchars($cliente['cnpj'] ?? ''); ?>" 
                           placeholder="00.000.000/0000-00">
                </div>
            </div>

            <div class="form-section">
                <h3>Contato</h3>
                
                <div class="form-group">
                    <label for="telefone" class="form-label">Telefone *</label>
                    <input type="tel" id="telefone" name="telefone" class="form-control" 
                           value="<?php echo htmlspecialchars($cliente['telefone']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">E-mail *</label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="endereco" class="form-label">Endereço</label>
                    <textarea id="endereco" name="endereco" class="form-control" rows="3"><?php echo htmlspecialchars($cliente['endereco'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="clientes-admin.php" class="btn btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php require_once '../includes/rodape.php'; ?>