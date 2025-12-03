<?php
/**
 * Dashboard Administrativo - Delta Vistoria
 * Versão Simplificada e Organizada
 */
$titulo_pagina = "Dashboard Administrativo";
require_once 'config.inc.php';
require_once '../includes/menu.php';
?>

<div class="main-content">
    <div class="page-header">
        <h1>Dashboard Administrativo</h1>
        <p>Bem-vindo, <?php echo $usuario['nome']; ?>! Resumo completo do sistema.</p>
    </div>

    <!-- ESTATÍSTICAS PRINCIPAIS -->
    <div class="stats-grid">
        <!-- TOTAL DE CLIENTES -->
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-info">
                <h3>
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM clientes");
                    echo $stmt->fetch()['total'];
                    ?>
                </h3>
                <p>Total de Clientes</p>
            </div>
        </div>

        <!-- AGENDAMENTOS POR STATUS -->
        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-info">
                <h3>
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM agendamentos WHERE status = 'agendado'");
                    echo $stmt->fetch()['total'];
                    ?>
                </h3>
                <p>Agendados</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <h3>
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM agendamentos WHERE status = 'confirmado'");
                    echo $stmt->fetch()['total'];
                    ?>
                </h3>
                <p>Confirmados</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🏁</div>
            <div class="stat-info">
                <h3>
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM agendamentos WHERE status = 'realizado'");
                    echo $stmt->fetch()['total'];
                    ?>
                </h3>
                <p>Realizados</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">❌</div>
            <div class="stat-info">
                <h3>
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM agendamentos WHERE status = 'cancelado'");
                    echo $stmt->fetch()['total'];
                    ?>
                </h3>
                <p>Cancelados</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-info">
                <h3>
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM agendamentos WHERE DATE(data_horario) = CURDATE()");
                    echo $stmt->fetch()['total'];
                    ?>
                </h3>
                <p>Agendamentos Hoje</p>
            </div>
        </div>
    </div>

    <!-- CONTEÚDO PRINCIPAL EM GRID -->
    <div class="content-grid">
        <!-- AGENDAMENTOS DE HOJE -->
        <div class="content-card">
            <div class="card-header">
                <h2>📋 Agendamentos de Hoje</h2>
                <span class="badge">
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM agendamentos WHERE DATE(data_horario) = CURDATE()");
                    echo $stmt->fetch()['total'];
                    ?>
                </span>
            </div>
            
            <?php
            $stmt = $pdo->prepare("
                SELECT a.*, c.nome as cliente_nome 
                FROM agendamentos a 
                JOIN clientes c ON a.cliente_id = c.id 
                WHERE DATE(a.data_horario) = CURDATE() 
                ORDER BY a.data_horario ASC 
                LIMIT 8
            ");
            $stmt->execute();
            $agendamentos_hoje = $stmt->fetchAll();
            ?>

            <?php if ($agendamentos_hoje): ?>
                <div class="simple-list">
                    <?php foreach ($agendamentos_hoje as $agendamento): ?>
                        <div class="list-item">
                            <div class="item-main">
                                <strong><?php echo htmlspecialchars($agendamento['cliente_nome']); ?></strong>
                                <span><?php echo date('H:i', strtotime($agendamento['data_horario'])); ?></span>
                            </div>
                            <div class="item-meta">
                                <?php if ($agendamento['placa_veiculo']): ?>
                                    <small>Placa: <?php echo $agendamento['placa_veiculo']; ?></small>
                                <?php endif; ?>
                                <?php echo getStatusBadge($agendamento['status']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>🎉 Nenhum agendamento para hoje.</p>
                </div>
            <?php endif; ?>
            
            <div class="card-footer">
                <a href="agendamentos-admin.php" class="btn btn-outline">Ver Todos os Agendamentos</a>
            </div>
        </div>

        <!-- ÚLTIMOS CLIENTES -->
        <div class="content-card">
            <div class="card-header">
                <h2>👥 Últimos Clientes</h2>
                <a href="clientes-cadastro.php" class="btn btn-primary btn-sm">+ Novo</a>
            </div>
            
            <?php
            $stmt = $pdo->query("
                SELECT * FROM clientes 
                ORDER BY criado_em DESC 
                LIMIT 6
            ");
            $ultimos_clientes = $stmt->fetchAll();
            ?>

            <?php if ($ultimos_clientes): ?>
                <div class="simple-list">
                    <?php foreach ($ultimos_clientes as $cliente): ?>
                        <div class="list-item">
                            <div class="item-main">
                                <strong><?php echo htmlspecialchars($cliente['nome']); ?></strong>
                                <span class="badge-type"><?php echo $cliente['tipo_pessoa']; ?></span>
                            </div>
                            <div class="item-meta">
                                <small><?php echo htmlspecialchars($cliente['email']); ?></small>
                                <small><?php echo htmlspecialchars($cliente['telefone']); ?></small>
                            </div>
                            <div class="item-actions">
                                <a href="clientes-form-alterar.php?id=<?php echo $cliente['id']; ?>" class="btn-link">Editar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>👥 Nenhum cliente cadastrado.</p>
                    <a href="clientes-cadastro.php" class="btn btn-primary">Cadastrar Primeiro Cliente</a>
                </div>
            <?php endif; ?>
            
            <div class="card-footer">
                <a href="clientes-admin.php" class="btn btn-outline">Ver Todos os Clientes</a>
            </div>
        </div>
    </div>

    <!-- RESUMO DOS PRÓXIMOS AGENDAMENTOS -->
    <div class="content-card">
        <div class="card-header">
            <h2>📅 Próximos Agendamentos</h2>
            <span class="badge">
                <?php
                $stmt = $pdo->query("SELECT COUNT(*) as total FROM agendamentos WHERE data_horario >= CURDATE() AND status != 'cancelado'");
                echo $stmt->fetch()['total'];
                ?>
            </span>
        </div>
        
        <?php
        $stmt = $pdo->prepare("
            SELECT a.*, c.nome as cliente_nome 
            FROM agendamentos a 
            JOIN clientes c ON a.cliente_id = c.id 
            WHERE a.data_horario >= CURDATE() 
            AND a.status != 'cancelado'
            ORDER BY a.data_horario ASC 
            LIMIT 6
        ");
        $stmt->execute();
        $proximos_agendamentos = $stmt->fetchAll();
        ?>

        <?php if ($proximos_agendamentos): ?>
            <div class="schedule-grid">
                <?php foreach ($proximos_agendamentos as $agendamento): ?>
                    <div class="schedule-item">
                        <div class="schedule-date">
                            <strong><?php echo date('d/m', strtotime($agendamento['data_horario'])); ?></strong>
                            <span><?php echo date('H:i', strtotime($agendamento['data_horario'])); ?></span>
                        </div>
                        <div class="schedule-info">
                            <strong><?php echo htmlspecialchars($agendamento['cliente_nome']); ?></strong>
                            <?php if ($agendamento['placa_veiculo']): ?>
                                <small>Placa: <?php echo $agendamento['placa_veiculo']; ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="schedule-status">
                            <?php echo getStatusBadge($agendamento['status']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>📅 Nenhum agendamento futuro.</p>
            </div>
        <?php endif; ?>
        
        <div class="card-footer">
            <a href="agendamentos-admin.php" class="btn btn-outline">Ver Agenda Completa</a>
        </div>
    </div>
</div>

<?php require_once '../includes/rodape.php'; ?>