<?php
/**
 * Solicitação de Agendamento - Delta Vistoria
 * Formulário público para clientes solicitarem vistorias
 */
session_start();
require_once '../includes/config.php';

$titulo_pagina = "Solicitar Vistoria";

// Processar formulário se for submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dados = [
            'tipo_pessoa' => $_POST['tipo_pessoa'],
            'nome' => trim($_POST['nome']),
            'cpf' => $_POST['cpf'] ?? null,
            'cnpj' => $_POST['cnpj'] ?? null,
            'telefone' => trim($_POST['telefone']),
            'email' => trim($_POST['email']),
            'endereco' => trim($_POST['endereco'] ?? ''),
            'placa_veiculo' => trim($_POST['placa_veiculo']),
            'tipo_veiculo' => trim($_POST['tipo_veiculo']),
            'data_preferencia' => $_POST['data_preferencia'],
            'observacoes' => trim($_POST['observacoes'] ?? '')
        ];

        // Validações básicas
        $campos_obrigatorios = ['nome', 'telefone', 'email', 'placa_veiculo', 'tipo_veiculo', 'data_preferencia'];
        foreach ($campos_obrigatorios as $campo) {
            if (empty($dados[$campo])) {
                throw new Exception("O campo " . ucfirst($campo) . " é obrigatório.");
            }
        }

        // Verificar se data é futura
        $data_preferencia = new DateTime($dados['data_preferencia']);
        $hoje = new DateTime();
        if ($data_preferencia <= $hoje) {
            throw new Exception("A data de preferência deve ser futura.");
        }

        // Verificar se cliente já existe pelo email
        $stmt = $pdo->prepare("SELECT id FROM clientes WHERE email = ?");
        $stmt->execute([$dados['email']]);
        $cliente_existente = $stmt->fetch();

        if ($cliente_existente) {
            $cliente_id = $cliente_existente['id'];
        } else {
            // Criar novo cliente
            $sql_cliente = "INSERT INTO clientes (tipo_pessoa, nome, cpf, cnpj, telefone, email, endereco) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql_cliente);
            $stmt->execute([
                $dados['tipo_pessoa'],
                $dados['nome'],
                $dados['cpf'],
                $dados['cnpj'],
                $dados['telefone'],
                $dados['email'],
                $dados['endereco']
            ]);
            $cliente_id = $pdo->lastInsertId();
        }

        // Criar agendamento
        $data_agendamento = $dados['data_preferencia'] . ' 09:00:00'; // Horário padrão
        
        $sql_agendamento = "INSERT INTO agendamentos (cliente_id, data_horario, placa_veiculo, tipo_veiculo, observacoes, status) 
                            VALUES (?, ?, ?, ?, ?, 'agendado')";
        $stmt = $pdo->prepare($sql_agendamento);
        $stmt->execute([
            $cliente_id,
            $data_agendamento,
            $dados['placa_veiculo'],
            $dados['tipo_veiculo'],
            $dados['observacoes']
        ]);

        $_SESSION['sucesso'] = "Solicitação de agendamento enviada com sucesso! Entraremos em contato para confirmar o horário.";
        header('Location: agendamento.php');
        exit;

    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}
?>

<?php require_once '../includes/topo.php'; ?>

<div class="main-content">
    <div class="container">
        <div class="form-container">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="color: #2c3e50; margin-bottom: 0.5rem;">Solicitar Vistoria</h1>
                <p style="color: #7f8c8d;">Preencha seus dados para solicitar uma vistoria</p>
            </div>

            <?php if (isset($erro)): ?>
                <div class="alert alert-error">
                    ❌ <?php echo $erro; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['sucesso'])): ?>
                <div class="alert alert-success">
                    ✅ <?php echo $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" id="form-agendamento">
                <div class="form-section">
                    <h3>📝 Seus Dados</h3>
                    
                    <div class="form-group">
                        <label for="tipo_pessoa" class="form-label">Tipo de Pessoa *</label>
                        <select id="tipo_pessoa" name="tipo_pessoa" class="form-control" required>
                            <option value="PF" selected>Pessoa Física</option>
                            <option value="PJ">Pessoa Jurídica</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nome" class="form-label">Nome Completo / Razão Social *</label>
                        <input type="text" id="nome" name="nome" class="form-control" required>
                    </div>

                    <div id="campo-cpf" class="form-group">
                        <label for="cpf" class="form-label">CPF *</label>
                        <input type="text" id="cpf" name="cpf" class="form-control" placeholder="000.000.000-00">
                    </div>

                    <div id="campo-cnpj" class="form-group" style="display: none;">
                        <label for="cnpj" class="form-label">CNPJ *</label>
                        <input type="text" id="cnpj" name="cnpj" class="form-control" placeholder="00.000.000/0000-00">
                    </div>

                    <div class="form-group">
                        <label for="telefone" class="form-label">Telefone *</label>
                        <input type="tel" id="telefone" name="telefone" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">E-mail *</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="endereco" class="form-label">Endereço</label>
                        <textarea id="endereco" name="endereco" class="form-control" rows="3" placeholder="Onde o veículo se encontra"></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h3>🚗 Dados do Veículo</h3>
                    
                    <div class="form-group">
                        <label for="placa_veiculo" class="form-label">Placa do Veículo *</label>
                        <input type="text" id="placa_veiculo" name="placa_veiculo" class="form-control" required style="text-transform:uppercase">
                    </div>

                    <div class="form-group">
                        <label for="tipo_veiculo" class="form-label">Tipo de Veículo *</label>
                        <select id="tipo_veiculo" name="tipo_veiculo" class="form-control" required>
                            <option value="">Selecione...</option>
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
                    <h3>📅 Preferência de Data</h3>
                    
                    <div class="form-group">
                        <label for="data_preferencia" class="form-label">Data Preferencial *</label>
                        <input type="date" id="data_preferencia" name="data_preferencia" class="form-control" 
                               min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                        <small class="form-text">Selecione a data que prefere para a vistoria</small>
                    </div>

                    <div class="form-group">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea id="observacoes" name="observacoes" class="form-control" rows="4" 
                                  placeholder="Informações adicionais sobre o veículo ou solicitações especiais..."></textarea>
                    </div>
                </div>

                <div class="form-info">
                    <h4>📋 Como funciona:</h4>
                    <ul>
                        <li>Você solicita através deste formulário</li>
                        <li>Nossa equipe entra em contato para confirmar data e horário</li>
                        <li>O agendamento fica como <strong>pré-agendado</strong> até a confirmação</li>
                        <li>Atendemos de segunda a sexta, das 8h às 18h</li>
                    </ul>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        📝 Solicitar Vistoria
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Toggle entre PF e PJ
document.getElementById('tipo_pessoa').addEventListener('change', function() {
    const tipo = this.value;
    document.getElementById('campo-cpf').style.display = tipo === 'PF' ? 'block' : 'none';
    document.getElementById('campo-cnpj').style.display = tipo === 'PJ' ? 'block' : 'none';
});

// Máscaras
document.getElementById('telefone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 10) {
        value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
    } else {
        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    }
    e.target.value = value;
});

document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    e.target.value = value;
});

document.getElementById('cnpj').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
    e.target.value = value;
});

// Converter placa para maiúsculas
document.getElementById('placa_veiculo').addEventListener('input', function(e) {
    this.value = this.value.toUpperCase();
});
</script>

<?php require_once '../includes/rodape.php'; ?>