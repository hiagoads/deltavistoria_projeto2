<?php
/**
 * Exclusão de Agendamento - Área Administrativa
 */
session_start();
require_once '../includes/config.php';
require_once 'config.inc.php';

// Verificar se o ID foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['erro'] = "Agendamento não especificado.";
    header('Location: agendamentos-admin.php');
    exit;
}

$agendamento_id = (int)$_GET['id'];

try {
    // Verificar se o agendamento existe
    $stmt = $pdo->prepare("
        SELECT a.*, c.nome as cliente_nome 
        FROM agendamentos a 
        JOIN clientes c ON a.cliente_id = c.id 
        WHERE a.id = ?
    ");
    $stmt->execute([$agendamento_id]);
    $agendamento = $stmt->fetch();
    
    if (!$agendamento) {
        $_SESSION['erro'] = "Agendamento não encontrado.";
        header('Location: agendamentos-admin.php');
        exit;
    }

    // Verificar se é um agendamento passado
    $agora = new DateTime();
    $data_agendamento = new DateTime($agendamento['data_horario']);
    
    if ($data_agendamento < $agora && $agendamento['status'] !== 'cancelado') {
        $_SESSION['erro'] = "Não é possível excluir agendamentos passados que não foram cancelados.";
        header('Location: agendamentos-admin.php');
        exit;
    }

    // Excluir agendamento
    $stmt = $pdo->prepare("DELETE FROM agendamentos WHERE id = ?");
    $stmt->execute([$agendamento_id]);

    $_SESSION['sucesso'] = "Agendamento excluído com sucesso!";

} catch (Exception $e) {
    $_SESSION['erro'] = "Erro ao excluir agendamento: " . $e->getMessage();
}

header('Location: agendamentos-admin.php');
exit;
?>