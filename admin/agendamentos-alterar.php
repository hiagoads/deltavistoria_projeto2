<?php
/**
 * Processamento de Cadastro e Edição de Agendamentos - Área Administrativa
 */
session_start();
require_once '../includes/config.php';
require_once 'config.inc.php';
require_once '../includes/topo.php';
require_once '../includes/menu.php';

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = "Método não permitido.";
    header('Location: agendamentos-admin.php');
    exit;
}

$action = $_GET['action'] ?? '';
$agendamento_id = $_GET['id'] ?? null;

try {
    if ($action === 'cadastrar') {
        // CADASTRAR NOVO AGENDAMENTO
        $dados = [
            'cliente_id' => (int)$_POST['cliente_id'],
            'data_agendamento' => $_POST['data_agendamento'],
            'hora_agendamento' => $_POST['hora_agendamento'],
            'placa_veiculo' => trim($_POST['placa_veiculo'] ?? ''),
            'tipo_veiculo' => trim($_POST['tipo_veiculo'] ?? ''),
            'observacoes' => trim($_POST['observacoes'] ?? ''),
            'status' => $_POST['status']
        ];

        // Validações
        if (empty($dados['cliente_id']) || empty($dados['data_agendamento']) || empty($dados['hora_agendamento'])) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos.");
        }

        // Combinar data e hora
        $data_horario = $dados['data_agendamento'] . ' ' . $dados['hora_agendamento'] . ':00';

        // Verificar se a data é futura
        if (strtotime($data_horario) < time()) {
            throw new Exception("A data e horário do agendamento devem ser futuros.");
        }

        // Verificar conflito de horário
        $stmt = $pdo->prepare("
            SELECT id FROM agendamentos 
            WHERE data_horario = ? 
            AND status NOT IN ('cancelado')
            LIMIT 1
        ");
        $stmt->execute([$data_horario]);
        if ($stmt->fetch()) {
            throw new Exception("Já existe um agendamento para este horário. Escolha outro horário.");
        }

        // Inserir agendamento
        $sql = "INSERT INTO agendamentos (cliente_id, data_horario, placa_veiculo, tipo_veiculo, observacoes, status) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dados['cliente_id'],
            $data_horario,
            $dados['placa_veiculo'] ?: null,
            $dados['tipo_veiculo'] ?: null,
            $dados['observacoes'] ?: null,
            $dados['status']
        ]);

        $_SESSION['sucesso'] = "Agendamento cadastrado com sucesso!";

    } elseif ($action === 'editar' && $agendamento_id) {
        // EDITAR AGENDAMENTO EXISTENTE
        $dados = [
            'cliente_id' => (int)$_POST['cliente_id'],
            'data_agendamento' => $_POST['data_agendamento'],
            'hora_agendamento' => $_POST['hora_agendamento'],
            'placa_veiculo' => trim($_POST['placa_veiculo'] ?? ''),
            'tipo_veiculo' => trim($_POST['tipo_veiculo'] ?? ''),
            'observacoes' => trim($_POST['observacoes'] ?? ''),
            'status' => $_POST['status'],
            'id' => $agendamento_id
        ];

        // Validações
        if (empty($dados['cliente_id']) || empty($dados['data_agendamento']) || empty($dados['hora_agendamento'])) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos.");
        }

        // Combinar data e hora
        $data_horario = $dados['data_agendamento'] . ' ' . $dados['hora_agendamento'] . ':00';

        // Verificar conflito de horário (excluindo o próprio agendamento)
        $stmt = $pdo->prepare("
            SELECT id FROM agendamentos 
            WHERE data_horario = ? 
            AND id != ? 
            AND status NOT IN ('cancelado')
            LIMIT 1
        ");
        $stmt->execute([$data_horario, $agendamento_id]);
        if ($stmt->fetch()) {
            throw new Exception("Já existe outro agendamento para este horário. Escolha outro horário.");
        }

        // Atualizar agendamento
        $sql = "UPDATE agendamentos 
                SET cliente_id = ?, data_horario = ?, placa_veiculo = ?, tipo_veiculo = ?, observacoes = ?, status = ? 
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dados['cliente_id'],
            $data_horario,
            $dados['placa_veiculo'] ?: null,
            $dados['tipo_veiculo'] ?: null,
            $dados['observacoes'] ?: null,
            $dados['status'],
            $dados['id']
        ]);

        $_SESSION['sucesso'] = "Agendamento atualizado com sucesso!";

    } else {
        throw new Exception("Ação inválida.");
    }

} catch (Exception $e) {
    $_SESSION['erro'] = $e->getMessage();
    $_SESSION['dados_form'] = $_POST;
    
    // Redirecionar de volta para o formulário apropriado
    if ($action === 'cadastrar') {
        header('Location: agendamentos-cadastro.php');
    } else {
        header('Location: agendamentos-form-alterar.php?id=' . $agendamento_id);
    }
    exit;
}

// Redirecionar para listagem em caso de sucesso
header('Location: agendamentos-admin.php');
exit;
?>