<?php
/**
 * Cadastro de Agendamentos - Área Administrativa
 */
$titulo_pagina = "Cadastrar Agendamento";
require_once 'config.inc.php';
require_once '../includes/topo.php';
require_once '../includes/menu.php';
// Buscar clientes para o select
$stmt = $pdo->query("SELECT id, nome, tipo_pessoa FROM clientes ORDER BY nome");
$clientes = $stmt->fetchAll();
?>

<div class="main-content">
    <div class="page-header">
        <h1>Cadastrar Novo Agendamento</h1>
        <p>Preencha os dados do agendamento abaixo</p>
    </div>

    <div class="content-card">
        <form action="agendamentos-alterar.php?action=cadastrar" method="POST" id="form-agendamento">
            <div class="form-section">
                <h3>Dados do Cliente</h3>
                
                <div class="form-group">
                    <label for="cliente_id" class="form-label">Cliente *</label>
                    <select id="cliente_id" name="cliente_id" class="form-control" required>
                        <option value="">Selecione um cliente...</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id']; ?>">
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
                           min="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="hora_agendamento" class="form-label">Horário *</label>
                    <select id="hora_agendamento" name="hora_agendamento" class="form-control" required>
                        <option value="">Selecione um horário...</option>
                        <?php
                        // Gerar horários das 8h às 18h
                        for ($hora = 8; $hora <= 18; $hora++):
                            for ($minuto = 0; $minuto < 60; $minuto += 30):
                                $hora_formatada = sprintf('%02d:%02d', $hora, $minuto);
                        ?>
                            <option value="<?php echo $hora_formatada; ?>"><?php echo $hora_formatada; ?></option>
                        <?php endfor; endfor; ?>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h3>Dados do Veículo</h3>
                
                <div class="form-group">
                    <label for="placa_veiculo" class="form-label">Placa do Veículo</label>
                    <input type="text" id="placa_veiculo" name="placa_veiculo" class="form-control" 
                           placeholder="ABC1D23" maxlength="10">
                </div>

                <div class="form-group">
                    <label for="tipo_veiculo" class="form-label">Tipo de Veículo</label>
                    <select id="tipo_veiculo" name="tipo_veiculo" class="form-control">
                        <option value="">Selecione o tipo...</option>
                        <option value="Carro Passeio">Carro Passeio</option>
                        <option value="Moto">Moto</option>
                        <option value="Caminhão">Caminhão</option>
                        <option value="Ônibus">Ônibus</option>
                        <option value="Van">Van</option>
                        <option value="Utilitário">Utilitário</option>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h3>Informações Adicionais</h3>
                
                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="pré-agendado">Pré-agendado</option>
                        <option value="confirmado" selected>Confirmado</option>
                        <option value="realizado">Realizado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="observacoes" class="form-label">Observações</label>
                    <textarea id="observacoes" name="observacoes" class="form-control" rows="4" 
                              placeholder="Informações adicionais sobre o agendamento..."></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Cadastrar Agendamento</button>
                <a href="agendamentos-admin.php" class="btn btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>