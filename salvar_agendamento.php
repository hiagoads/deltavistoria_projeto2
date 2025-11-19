<?php

$servidor = "localhost"; 
$usuario = "seu_usuario_mysql"; 
$senha = "sua_senha_mysql"; 
$banco = "delta_vistoria_db"; 


$conexao = new mysqli($servidor, $usuario, $senha, $banco);


if ($conexao->connect_error) {
    die("Falha na Conexão: " . $conexao->connect_error);
}


$nome = isset($_POST['nome']) ? $conexao->real_escape_string($_POST['nome']) : '';
$telefone = isset($_POST['telefone']) ? $conexao->real_escape_string($_POST['telefone']) : '';
$email = isset($_POST['email']) ? $conexao->real_escape_string($_POST['email']) : '';
$data_agendamento = isset($_POST['data']) ? $conexao->real_escape_string($_POST['data']) : '';
$placa = isset($_POST['placa']) ? $conexao->real_escape_string($_POST['placa']) : '';


$sql = "INSERT INTO agendamentos (nome, telefone, email, data_agendamento, placa) 
        VALUES ('$nome', '$telefone', '$email', '$data_agendamento', '$placa')";

if ($conexao->query($sql) === TRUE) {
    
    echo "<h1>✅ Agendamento Realizado com Sucesso!</h1>";
    echo "<p>Em breve entraremos em contato para confirmar os detalhes.</p>";
    echo "<a href='index.html'>Voltar à Página Inicial</a>";
} else {

    echo "<h1>❌ Erro ao Agendar</h1>";
    echo "<p>Ocorreu um erro: " . $conexao->error . "</p>";
}

// 7. FECHAR A CONEXÃO
$conexao->close();

?>