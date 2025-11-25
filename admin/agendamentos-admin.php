<?php
/**
 * Listagem de Agendamentos - Área Administrativa
 */
$titulo_pagina = "Gerenciar Agendamentos";
require_once 'config.inc.php';
require_once '../includes/topo.php';

// Paginação
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$itens_por_pagina = $admin_config['itens_por_pagina'];
$offset = ($pagina - 1) * $itens_por_pagina;

// Filtros
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';

$where = "WHERE 1=1";
$params = [];

if (!empty($busca)) {
    $where .= " AND (c.nome LIKE ? OR c.email LIKE ? OR a.placa_veiculo LIKE ?)";
    $termo_busca = "%$busca%";
    $params = array_merge($params, [$termo_busca, $termo_busca, $termo_busca]);
}

if (!empty($status)) {
    $where .= " AND a.status = ?";
    $params[] = $status;
}

if (!empty($data_inicio)) {
    $where .= " AND DATE(a.data_horario) >= ?";
    $params[] = $data_inicio;
}

if (!empty($data_fim)) {
    $where .= " AND DATE(a.data_horario) <= ?";
    $params[] = $data_fim;
}

// Total de registros
$sql_count = "SELECT COUNT(*) as total FROM agendamentos a JOIN clientes c ON a.cliente_id = c.id $where";
$stmt_count = $pdo->prepare($sql_count);
$stmt_count->execute($params);
$total_agendamentos = $stmt_count->fetch()['total'];
$total_paginas = ceil($total_agendamentos / $itens_por_pagina);

// Dados da página atual
$sql = "SELECT a.*, c.nome as cliente_nome, c.telefone, c.email 
        FROM agendamentos a 
        JOIN clientes c ON a.cliente_id = c.id 
        $where 
        ORDER BY a.data_horario DESC 
        LIMIT $offset, $itens_por_pagina";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$agendamentos = $stmt->fetchAll();
?>

<div class="main-content">
    <div class="page-header">
        <h1>Gerenciar Agendamentos</h1>
        <div class="header-actions">
            <a href="agendamentos-cadastro.php" class="btn btn-primary">Novo Agendamento</a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-card">
        <form method="GET" class="filter-form">
            <div class="filter-row">
                <div class="filter-group">
                    <input type="text" name="busca" placeholder="Buscar por cliente, e-mail ou placa..." 
                           value="<?php echo htmlspecialchars($busca); ?>" class="form-control">
                </div>
                <div class="filter-group">
                    <select name="status" class="form-control">
                        <option value="">Todos os status</option>
                        <option value="pré-agendado" <?php echo $status == 'pré-agendado' ? 'selected' : ''; ?>>Pré-agendado</option>
                        <option value="confirmado" <?php echo $status == 'confirmado' ? 'selected' : ''; ?>>Confirmado</option>
                        <option value="realizado" <?php echo $status == 'realizado' ? 'selected' : ''; ?>>Realizado</option>
                        <option value="cancelado" <?php echo $status == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                    </select>
                </div>
            </div>
            <div class="filter-row">
                <div class="filter-group">
                    <label>Data Início:</label>
                    <input type="date" name="data_inicio" value="<?php echo htmlspecialchars($data_inicio); ?>" class="form-control">
                </div>
                <div class="filter-group">
                    <label>Data Fim:</label>
                    <input type="date" name="data_fim" value="<?php echo htmlspecialchars($data_fim); ?>" class="form-control">
                </div>
                <button type="submit" class="btn btn-secondary">Filtrar</button>
                <?php if ($busca || $status || $data_inicio || $data_fim): ?>
                    <a href="agendamentos-admin.php" class="btn btn-outline">Limpar</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Lista de Agendamentos -->
    <div class="content-card">
        <?php if ($agendamentos): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Data/Horário</th>
                            <th>Placa</th>
                            <th>Observações</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agendamentos as $agendamento): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($agendamento['cliente_nome']); ?></strong><br>
                                    <small><?php echo htmlspecialchars($agendamento['email']); ?></small><br>
                                    <small><?php echo htmlspecialchars($agendamento['telefone']); ?></small>
                                </td>
                                <td>
                                    <?php echo date('d/m/Y', strtotime($agendamento['data_horario'])); ?><br>
                                    <small><?php echo date('H:i', strtotime($agendamento['data_horario'])); ?></small>
                                </td>
                                <td><?php echo $agendamento['placa_veiculo'] ?: '-'; ?></td>
                                <td>
                                    <?php if ($agendamento['observacoes']): ?>
                                        <span title="<?php echo htmlspecialchars($agendamento['observacoes']); ?>">
                                            <?php echo strlen($agendamento['observacoes']) > 50 ? 
                                                substr($agendamento['observacoes'], 0, 50) . '...' : 
                                                $agendamento['observacoes']; ?>
                                        </span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo getStatusBadge($agendamento['status']); ?></td>
                                <td class="actions">
                                    <a href="agendamentos-form-alterar.php?id=<?php echo $agendamento['id']; ?>" 
                                       class="btn-action" title="Editar">✏️</a>
                                    <a href="agendamentos-excluir.php?id=<?php echo $agendamento['id']; ?>" 
                                        class="btn-action btn-danger" 
                                        onclick="return confirm('Tem certeza que deseja excluir este agendamento? Esta ação não pode ser desfeita.')" 
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
                        <a href="?pagina=<?php echo $pagina - 1; ?>&busca=<?php echo urlencode($busca); ?>&status=<?php echo $status; ?>&data_inicio=<?php echo $data_inicio; ?>&data_fim=<?php echo $data_fim; ?>" 
                           class="page-link">← Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="?pagina=<?php echo $i; ?>&busca=<?php echo urlencode($busca); ?>&status=<?php echo $status; ?>&data_inicio=<?php echo $data_inicio; ?>&data_fim=<?php echo $data_fim; ?>" 
                           class="page-link <?php echo $i == $pagina ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($pagina < $total_paginas): ?>
                        <a href="?pagina=<?php echo $pagina + 1; ?>&busca=<?php echo urlencode($busca); ?>&status=<?php echo $status; ?>&data_inicio=<?php echo $data_inicio; ?>&data_fim=<?php echo $data_fim; ?>" 
                           class="page-link">Próxima →</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="empty-state">
                <p>Nenhum agendamento encontrado.</p>
                <a href="agendamentos-cadastro.php" class="btn btn-primary">Criar Primeiro Agendamento</a>
            </div>
        <?php endif; ?>
    </div>
</div>