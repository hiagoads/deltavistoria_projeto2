<?php
/**
 * Exclusão de Cliente - Área Administrativa
 */
session_start();
require_once '../includes/config.php';
require_once 'config.inc.php';

// Verificar se o ID foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['erro'] = "Cliente não especificado.";
    header('Location: clientes-admin.php');
    exit;
}

$cliente_id = (int)$_GET['id'];

try {
    // Verificar se o cliente existe
    $stmt = $pdo->prepare("SELECT nome FROM clientes WHERE id = ?");
    $stmt->execute([$cliente_id]);
    $cliente = $stmt->fetch();
    
    if (!$cliente) {
        $_SESSION['erro'] = "Cliente não encontrado.";
        header('Location: clientes-admin.php');
        exit;
    }

    // Verificar se existem agendamentos futuros
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM agendamentos WHERE cliente_id = ? AND data_horario > NOW()");
    $stmt->execute([$cliente_id]);
    $agendamentos_futuros = $stmt->fetch()['total'];
    
    if ($agendamentos_futuros > 0) {
        $_SESSION['erro'] = "Não é possível excluir o cliente pois existem agendamentos futuros. Cancele os agendamentos primeiro.";
        header('Location: clientes-admin.php');
        exit;
    }

    // Excluir agendamentos do cliente
    $stmt = $pdo->prepare("DELETE FROM agendamentos WHERE cliente_id = ?");
    $stmt->execute([$cliente_id]);

    // Excluir cliente
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->execute([$cliente_id]);

    $_SESSION['sucesso'] = "Cliente '{$cliente['nome']}' excluído com sucesso!";

} catch (Exception $e) {
    $_SESSION['erro'] = "Erro ao excluir cliente: " . $e->getMessage();
}

header('Location: clientes-admin.php');
exit;
?>