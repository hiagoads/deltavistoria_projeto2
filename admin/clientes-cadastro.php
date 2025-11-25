<?php
/**
 * Cadastro de Clientes - Área Administrativa
 */
$titulo_pagina = "Cadastrar Cliente";
require_once 'config.inc.php';
require_once '../includes/menu.php';
?>

<div class="main-content">
    <div class="page-header">
        <h1>Cadastrar Novo Cliente</h1>
        <p>Preencha os dados do cliente abaixo</p>
    </div>

    <div class="content-card">
        <form action="clientes-alterar.php?action=cadastrar" method="POST" id="form-cliente">
            <div class="form-section">
                <h3>Dados Pessoais</h3>
                
                <div class="form-group">
                    <label for="tipo_pessoa" class="form-label">Tipo de Pessoa *</label>
                    <select id="tipo_pessoa" name="tipo_pessoa" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="PF">Pessoa Física</option>
                        <option value="PJ">Pessoa Jurídica</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome" class="form-label">Nome Completo / Razão Social *</label>
                    <input type="text" id="nome" name="nome" class="form-control" required maxlength="150">
                </div>

                <div id="campo-cpf" class="form-group" style="display: none;">
                    <label for="cpf" class="form-label">CPF *</label>
                    <input type="text" id="cpf" name="cpf" class="form-control" placeholder="000.000.000-00">
                </div>

                <div id="campo-cnpj" class="form-group" style="display: none;">
                    <label for="cnpj" class="form-label">CNPJ *</label>
                    <input type="text" id="cnpj" name="cnpj" class="form-control" placeholder="00.000.000/0000-00">
                </div>
            </div>

            <div class="form-section">
                <h3>Contato</h3>
                
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
                    <textarea id="endereco" name="endereco" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3>Configuração de Acesso</h3>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="criar_usuario" id="criar_usuario" checked> 
                        Criar usuário para acesso ao sistema
                    </label>
                </div>

                <div id="dados-acesso" class="form-group">
                    <div class="form-group">
                        <label for="senha" class="form-label">Senha Inicial *</label>
                        <input type="password" id="senha" name="senha" class="form-control" value="senha123">
                        <small class="form-text">Senha padrão: "senha123" - o usuário poderá alterar depois</small>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
                <a href="clientes-admin.php" class="btn btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>