<?php
/**
 * Listagem de Clientes - Área Administrativa
 */
$titulo_pagina = "Gerenciar Clientes";
require_once 'config.inc.php';
require_once '../includes/menu.php';

// Paginação
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$itens_por_pagina = $admin_config['itens_por_pagina'];
$offset = ($pagina - 1) * $itens_por_pagina;

// Busca e filtros
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

$where = "WHERE 1=1";
$params = [];

if (!empty($busca)) {
    $where .= " AND (c.nome LIKE ? OR c.email LIKE ? OR c.cpf LIKE ? OR c.cnpj LIKE ?)";
    $termo_busca = "%$busca%";
    $params = array_merge($params, [$termo_busca, $termo_busca, $termo_busca, $termo_busca]);
}

if (!empty($tipo)) {
    $where .= " AND c.tipo_pessoa = ?";
    $params[] = $tipo;
}

// Total de registros
$sql_count = "SELECT COUNT(*) as total FROM clientes c $where";
$stmt_count = $pdo->prepare($sql_count);
$stmt_count->execute($params);
$total_clientes = $stmt_count->fetch()['total'];
$total_paginas = ceil($total_clientes / $itens_por_pagina);

// Dados da página atual - CORREÇÃO AQUI
$sql = "SELECT c.* 
        FROM clientes c 
        $where 
        ORDER BY c.criado_em DESC 
        LIMIT $offset, $itens_por_pagina";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$clientes = $stmt->fetchAll();
?>

<div class="main-content">
    <div class="page-header">
        <h1>Gerenciar Clientes</h1>
        <div class="header-actions">
            <a href="clientes-cadastro.php" class="btn btn-primary">Novo Cliente</a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-card">
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <input type="text" name="busca" placeholder="Buscar por nome, e-mail, CPF/CNPJ..." 
                       value="<?php echo htmlspecialchars($busca); ?>" class="form-control">
            </div>
            <div class="filter-group">
                <select name="tipo" class="form-control">
                    <option value="">Todos os tipos</option>
                    <option value="PF" <?php echo $tipo == 'PF' ? 'selected' : ''; ?>>Pessoa Física</option>
                    <option value="PJ" <?php echo $tipo == 'PJ' ? 'selected' : ''; ?>>Pessoa Jurídica</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">Filtrar</button>
            <?php if ($busca || $tipo): ?>
                <a href="clientes-admin.php" class="btn btn-outline">Limpar</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Lista de Clientes -->
    <div class="content-card">
        <?php if ($clientes): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome/Razão Social</th>
                            <th>Tipo</th>
                            <th>Documento</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th>Cadastrado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                                <td><?php echo $cliente['tipo_pessoa']; ?></td>
                                <td><?php echo formatarCPFCNPJ($cliente['cpf'] ?? $cliente['cnpj']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($cliente['criado_em'])); ?></td>
                                <td class="actions">
                                    <a href="clientes-form-alterar.php?id=<?php echo $cliente['id']; ?>" 
                                       class="btn-action" title="Editar">✏️</a>

                                    <a href="clientes-excluir.php?id=<?php echo $cliente['id']; ?>" 
                                        class="btn-action btn-danger" 
                                        onclick="return confirm('Tem certeza que deseja excluir <?php echo addslashes($cliente['nome']); ?>? Esta ação não pode ser desfeita.')" 
                                        title="Excluir">🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <?php if ($total_paginas > 1): ?>
                <div class="pagination">
                    <?php if ($pagina > 1): ?>
                        <a href="?pagina=<?php echo $pagina - 1; ?>&busca=<?php echo urlencode($busca); ?>&tipo=<?php echo $tipo; ?>" class="page-link">← Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="?pagina=<?php echo $i; ?>&busca=<?php echo urlencode($busca); ?>&tipo=<?php echo $tipo; ?>" 
                           class="page-link <?php echo $i == $pagina ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($pagina < $total_paginas): ?>
                        <a href="?pagina=<?php echo $pagina + 1; ?>&busca=<?php echo urlencode($busca); ?>&tipo=<?php echo $tipo; ?>" class="page-link">Próxima →</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="empty-state">
                <p>Nenhum cliente encontrado.</p>
                <a href="clientes-cadastro.php" class="btn btn-primary">Cadastrar Primeiro Cliente</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/rodape.php'; ?>