<?php
/**
 * Configuração do Banco de Dados - Delta Vistoria
 * Conexão com MySQL usando PDO
 */

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'delta_vistoria';
$username = 'root';
$password = '';

// Configurações do sistema
$sistema_nome = "Delta Vistoria";
$sistema_versao = "2.0"; // Versão nova

// Timezone do Brasil
date_default_timezone_set('America/Sao_Paulo');

// Iniciar sessão apenas se não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    // Criar conexão PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Configurar para mostrar erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
} catch(PDOException $e) {
    die("<div style='padding: 20px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px;'>
            <h3>Erro de Conexão com o Banco de Dados</h3>
            <p><strong>Mensagem:</strong> " . $e->getMessage() . "</p>
         </div>");
}

// Funções auxiliares
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function formatarData($data, $formato = 'd/m/Y H:i') {
    if (empty($data) || $data == '0000-00-00 00:00:00') return '-';
    $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $data);
    return $datetime ? $datetime->format($formato) : '-';
}

function redirect($url) {
    header("Location: " . $url);
    exit;
}
?>