<?php
/**
 * Formulário de Edição de Agendamento - Área Administrativa
 */
$titulo_pagina = "Editar Agendamento";
require_once 'config.inc.php';
require_once '../includes/topo.php';
require_once '../includes/menu.php';

// Verificar se o ID foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['erro'] = "Agendamento não especificado.";
    header('Location: agendamentos-admin.php');
    exit;
}

$agendamento_id = (int)$_GET['id'];

// Buscar dados do agendamento
try {
    $sql = "SELECT a.*, c.nome as cliente_nome, c.tipo_pessoa 
            FROM agendamentos a 
            JOIN clientes c ON a.cliente_id = c.id 
            WHERE a.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$agendamento_id]);
    $agendamento = $stmt->fetch();
    
    if (!$agendamento) {
        $_SESSION['erro'] = "Agendamento não encontrado.";
        header('Location: agendamentos-admin.php');
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['erro'] = "Erro ao carregar dados do agendamento.";
    header('Location: agendamentos-admin.php');
    exit;
}

// Buscar clientes para o select
$stmt = $pdo->query("SELECT id, nome, tipo_pessoa FROM clientes ORDER BY nome");
$clientes = $stmt->fetchAll();

// Separar data e hora
$data = date('Y-m-d', strtotime($agendamento['data_horario']));
$hora = date('H:i', strtotime($agendamento['data_horario']));
?>

<div class="main-content">
    <div class="page-header">
        <h1>Editar Agendamento</h1>
        <p>Editando agendamento de <?php echo htmlspecialchars($agendamento['cliente_nome']); ?></p>
    </div>

    <div class="content-card">
        <form action="agendamentos-alterar.php?action=editar&id=<?php echo $agendamento_id; ?>" method="POST" id="form-agendamento">
            <div class="form-section">
                <h3>Dados do Cliente</h3>
                
                <div class="form-group">
                    <label for="cliente_id" class="form-label">Cliente *</label>
                    <select id="cliente_id" name="cliente_id" class="form-control" required>
                        <option value="">Selecione um cliente...</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id']; ?>" 
                                <?php echo $cliente['id'] == $agendamento['cliente_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cliente['nome']); ?> (<?php echo $cliente['tipo_pessoa']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h3>Data e Horário</h3>
                
                <div class="form-group">
                    <label for="data_agendamento" class="form-label">Data *</label>
                    <input type="date" id="data_agendamento" name="data_agendamento" class="form-control" 
                           value="<?php echo $data; ?>" min="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="hora_agendamento" class="form-label">Horário *</label>
                    <select id="hora_agendamento" name="hora_agendamento" class="form-control" required>
                        <option value="">Selecione um horário...</option>
                        <?php
                        for ($hora = 8; $hora <= 18; $hora++):
                            for ($minuto = 0; $minuto < 60; $minuto += 30):
                                $hora_formatada = sprintf('%02d:%02d', $hora, $minuto);
                                $selected = $hora_formatada == $hora ? 'selected' : '';
                        ?>
                            <option value="<?php echo $hora_formatada; ?>" <?php echo $selected; ?>>
                                <?php echo $hora_formatada; ?>
                            </option>
                        <?php endfor; endfor; ?>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h3>Dados do Veículo</h3>
                
                <div class="form-group">
                    <label for="placa_veiculo" class="form-label">Placa do Veículo</label>
                    <input type="text" id="placa_veiculo" name="placa_veiculo" class="form-control" 
                           value="<?php echo htmlspecialchars($agendamento['placa_veiculo']); ?>" 
                           placeholder="ABC1D23" maxlength="10">
                </div>

                <div class="form-group">
                    <label for="tipo_veiculo" class="form-label">Tipo de Veículo</label>
                    <select id="tipo_veiculo" name="tipo_veiculo" class="form-control">
                        <option value="">Selecione o tipo...</option>
                        <option value="Carro Passeio" <?php echo $agendamento['tipo_veiculo'] == 'Carro Passeio' ? 'selected' : ''; ?>>Carro Passeio</option>
                        <option value="Moto" <?php echo $agendamento['tipo_veiculo'] == 'Moto' ? 'selected' : ''; ?>>Moto</option>
                        <option value="Caminhão" <?php echo $agendamento['tipo_veiculo'] == 'Caminhão' ? 'selected' : ''; ?>>Caminhão</option>
                        <option value="Ônibus" <?php echo $agendamento['tipo_veiculo'] == 'Ônibus' ? 'selected' : ''; ?>>Ônibus</option>
                        <option value="Van" <?php echo $agendamento['tipo_veiculo'] == 'Van' ? 'selected' : ''; ?>>Van</option>
                        <option value="Utilitário" <?php echo $agendamento['tipo_veiculo'] == 'Utilitário' ? 'selected' : ''; ?>>Utilitário</option>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h3>Informações Adicionais</h3>
                
                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="pré-agendado" <?php echo $agendamento['status'] == 'pré-agendado' ? 'selected' : ''; ?>>Pré-agendado</option>
                        <option value="confirmado" <?php echo $agendamento['status'] == 'confirmado' ? 'selected' : ''; ?>>Confirmado</option>
                        <option value="realizado" <?php echo $agendamento['status'] == 'realizado' ? 'selected' : ''; ?>>Realizado</option>
                        <option value="cancelado" <?php echo $agendamento['status'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="observacoes" class="form-label">Observações</label>
                    <textarea id="observacoes" name="observacoes" class="form-control" rows="4" 
                              placeholder="Informações adicionais sobre o agendamento..."><?php echo htmlspecialchars($agendamento['observacoes']); ?></textarea>
                </div>
            </div>

            <div class="form-info">
                <p><strong>Cadastrado em:</strong> <?php echo date('d/m/Y H:i', strtotime($agendamento['criado_em'])); ?></p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="agendamentos-admin.php" class="btn btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>