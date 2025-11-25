<?php
/**
 * Configurações da Área Administrativa - Delta Vistoria
 */
require_once '../includes/config.php';
require_once '../includes/auth.php';
$usuario = verificaAdmin(); // Apenas admin acessa

// Configurações
$admin_config = [
    'itens_por_pagina' => 10
];

// Função para formatar CPF/CNPJ
function formatarCPFCNPJ($documento) {
    if (empty($documento)) return '-';
    if (strlen($documento) == 14) {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $documento);
    } else {
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $documento);
    }
}

// Função para mostrar status
function getStatusBadge($status) {
    $classes = [
        'agendado' => 'status-pending',
        'confirmado' => 'status-confirmed', 
        'realizado' => 'status-completed',
        'cancelado' => 'status-cancelled'
    ];
    return '<span class="status-badge ' . ($classes[$status] ?? 'status-pending') . '">' . ucfirst($status) . '</span>';
}
?>