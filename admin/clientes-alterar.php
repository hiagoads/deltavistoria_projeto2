<?php
/**
 * Processamento de Cadastro e Edição de Clientes - Área Administrativa
 * Versão corrigida para novo banco de dados
 */
session_start();
require_once '../includes/config.php';
require_once 'config.inc.php';

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = "Método não permitido.";
    header('Location: clientes-admin.php');
    exit;
}

$action = $_GET['action'] ?? '';
$cliente_id = $_GET['id'] ?? null;

try {
    if ($action === 'cadastrar') {
        // CADASTRAR NOVO CLIENTE
        $dados = [
            'tipo_pessoa' => $_POST['tipo_pessoa'],
            'nome' => trim($_POST['nome']),
            'cpf' => $_POST['cpf'] ?? null,
            'cnpj' => $_POST['cnpj'] ?? null,
            'telefone' => trim($_POST['telefone']),
            'email' => trim($_POST['email']),
            'endereco' => trim($_POST['endereco'] ?? '')
        ];

        // Validações
        if (empty($dados['nome']) || empty($dados['telefone']) || empty($dados['email'])) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos.");
        }

        if ($dados['tipo_pessoa'] === 'PF' && empty($dados['cpf'])) {
            throw new Exception("CPF é obrigatório para Pessoa Física.");
        }

        if ($dados['tipo_pessoa'] === 'PJ' && empty($dados['cnpj'])) {
            throw new Exception("CNPJ é obrigatório para Pessoa Jurídica.");
        }

        // Verificar se email já existe
        $stmt = $pdo->prepare("SELECT id FROM clientes WHERE email = ?");
        $stmt->execute([$dados['email']]);
        if ($stmt->fetch()) {
            throw new Exception("Já existe um cliente cadastrado com este e-mail.");
        }

        // Inserir cliente
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

        $_SESSION['sucesso'] = "Cliente cadastrado com sucesso!";

    } elseif ($action === 'editar' && $cliente_id) {
        // EDITAR CLIENTE EXISTENTE
        $dados = [
            'tipo_pessoa' => $_POST['tipo_pessoa'],
            'nome' => trim($_POST['nome']),
            'cpf' => $_POST['cpf'] ?? null,
            'cnpj' => $_POST['cnpj'] ?? null,
            'telefone' => trim($_POST['telefone']),
            'email' => trim($_POST['email']),
            'endereco' => trim($_POST['endereco'] ?? ''),
            'id' => $cliente_id
        ];

        // Validações
        if (empty($dados['nome']) || empty($dados['telefone']) || empty($dados['email'])) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos.");
        }

        // Verificar se email já existe em outro cliente
        $stmt = $pdo->prepare("SELECT id FROM clientes WHERE email = ? AND id != ?");
        $stmt->execute([$dados['email'], $cliente_id]);
        if ($stmt->fetch()) {
            throw new Exception("Já existe outro cliente cadastrado com este e-mail.");
        }

        // Atualizar cliente
        $sql_cliente = "UPDATE clientes 
                        SET tipo_pessoa = ?, nome = ?, cpf = ?, cnpj = ?, telefone = ?, email = ?, endereco = ? 
                        WHERE id = ?";
        $stmt = $pdo->prepare($sql_cliente);
        $stmt->execute([
            $dados['tipo_pessoa'],
            $dados['nome'],
            $dados['cpf'],
            $dados['cnpj'],
            $dados['telefone'],
            $dados['email'],
            $dados['endereco'],
            $dados['id']
        ]);

        $_SESSION['sucesso'] = "Cliente atualizado com sucesso!";

    } else {
        throw new Exception("Ação inválida.");
    }

} catch (Exception $e) {
    $_SESSION['erro'] = $e->getMessage();
    $_SESSION['dados_form'] = $_POST;
    
    // Redirecionar de volta para o formulário apropriado
    if ($action === 'cadastrar') {
        header('Location: clientes-cadastro.php');
    } else {
        header('Location: clientes-form-alterar.php?id=' . $cliente_id);
    }
    exit;
}

// Redirecionar para listagem em caso de sucesso
header('Location: clientes-admin.php');
exit;
?>