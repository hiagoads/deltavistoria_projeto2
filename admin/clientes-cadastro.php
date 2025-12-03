<?php
/**
 * Cadastro de Clientes - Área Administrativa
 */
$titulo_pagina = "Cadastrar Cliente";
require_once 'config.inc.php';
require_once '../includes/menu.php';

// Recuperar dados do formulário em caso de erro
$dados_form = $_SESSION['dados_form'] ?? [];
unset($_SESSION['dados_form']);
?>

<div class="main-content">
    <div class="page-header">
        <h1>Cadastrar Novo Cliente</h1>
        <p>Preencha os dados do cliente abaixo</p>
    </div>

    <?php if (isset($_SESSION['erro'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?>
        </div>
    <?php endif; ?>

    <div class="content-card">
        <form action="clientes-alterar.php?action=cadastrar" method="POST" id="form-cliente">
            <div class="form-section">
                <h3>Dados Pessoais</h3>
                
                <div class="form-group">
                    <label for="tipo_pessoa" class="form-label">Tipo de Pessoa *</label>
                    <select id="tipo_pessoa" name="tipo_pessoa" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="PF" <?php echo ($dados_form['tipo_pessoa'] ?? '') === 'PF' ? 'selected' : ''; ?>>Pessoa Física</option>
                        <option value="PJ" <?php echo ($dados_form['tipo_pessoa'] ?? '') === 'PJ' ? 'selected' : ''; ?>>Pessoa Jurídica</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome" class="form-label">Nome Completo / Razão Social *</label>
                    <input type="text" id="nome" name="nome" class="form-control" required maxlength="150" 
                           value="<?php echo htmlspecialchars($dados_form['nome'] ?? ''); ?>">
                </div>

                <div id="campo-cpf" class="form-group" style="display: none;">
                    <label for="cpf" class="form-label">CPF *</label>
                    <input type="text" id="cpf" name="cpf" class="form-control" placeholder="000.000.000-00"
                           value="<?php echo htmlspecialchars($dados_form['cpf'] ?? ''); ?>">
                </div>

                <div id="campo-cnpj" class="form-group" style="display: none;">
                    <label for="cnpj" class="form-label">CNPJ *</label>
                    <input type="text" id="cnpj" name="cnpj" class="form-control" placeholder="00.000.000/0000-00"
                           value="<?php echo htmlspecialchars($dados_form['cnpj'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-section">
                <h3>Contato</h3>
                
                <div class="form-group">
                    <label for="telefone" class="form-label">Telefone *</label>
                    <input type="tel" id="telefone" name="telefone" class="form-control" required
                           value="<?php echo htmlspecialchars($dados_form['telefone'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">E-mail *</label>
                    <input type="email" id="email" name="email" class="form-control" required
                           value="<?php echo htmlspecialchars($dados_form['email'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="endereco" class="form-label">Endereço</label>
                    <textarea id="endereco" name="endereco" class="form-control" rows="3"><?php echo htmlspecialchars($dados_form['endereco'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
                <a href="clientes-admin.php" class="btn btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>

 <?php require_once '../includes/rodape.php'; ?>

<!-- JavaScript para mostrar campos CPF/CNPJ conforme tipo de pessoa -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoPessoaSelect = document.getElementById('tipo_pessoa');
    const campoCpf = document.getElementById('campo-cpf');
    const campoCnpj = document.getElementById('campo-cnpj');
    const cpfInput = document.getElementById('cpf');
    const cnpjInput = document.getElementById('cnpj');

    // Verificar valor atual (em caso de retorno de erro)
    function atualizarCampos() {
        const valor = tipoPessoaSelect.value;
        
        if (valor === 'PF') {
            campoCpf.style.display = 'block';
            campoCnpj.style.display = 'none';
            cnpjInput.removeAttribute('required');
            cpfInput.setAttribute('required', 'required');
        } else if (valor === 'PJ') {
            campoCpf.style.display = 'none';
            campoCnpj.style.display = 'block';
            cpfInput.removeAttribute('required');
            cnpjInput.setAttribute('required', 'required');
        } else {
            campoCpf.style.display = 'none';
            campoCnpj.style.display = 'none';
            cpfInput.removeAttribute('required');
            cnpjInput.removeAttribute('required');
        }
    }

    // Executar ao carregar
    atualizarCampos();

    // Executar ao mudar
    tipoPessoaSelect.addEventListener('change', atualizarCampos);

    // Máscaras para CPF e CNPJ
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.substring(0, 11);
            
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            }
            e.target.value = value;
        });
    }

    if (cnpjInput) {
        cnpjInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 14) value = value.substring(0, 14);
            
            if (value.length <= 14) {
                value = value.replace(/(\d{2})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1/$2');
                value = value.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
            }
            e.target.value = value;
        });
    }

    // Máscara para telefone
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 11) value = value.substring(0, 11);
            
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = value;
        });
    }
});
</script>