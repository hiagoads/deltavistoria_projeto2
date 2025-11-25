-- ============================================================
-- BANCO DE DADOS: delta_vistoria
-- Projeto universitário - Sistema de Vistoria de Veículos
-- Contém CRUD de Clientes e CRUD de Agendamentos
-- ============================================================

-- ------------------------------
-- 1. Criar o banco de dados
-- ------------------------------
CREATE DATABASE IF NOT EXISTS delta_vistoria
    COLLATE utf8mb4_unicode_ci;

USE delta_vistoria;

-- ------------------------------
-- 2. Tabela de Clientes
-- Pessoa Física (CPF) ou Pessoa Jurídica (CNPJ)
-- ------------------------------

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_pessoa ENUM('PF', 'PJ') NOT NULL,
    nome VARCHAR(150) NOT NULL,
    cpf VARCHAR(14) NULL,
    cnpj VARCHAR(18) NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Regras adicionais (opcionais para validar números únicos)
ALTER TABLE clientes ADD UNIQUE (cpf);
ALTER TABLE clientes ADD UNIQUE (cnpj);
ALTER TABLE clientes ADD UNIQUE (email);

-- ------------------------------
-- 3. Tabela de Agendamentos
-- Relacionada com clientes
-- ------------------------------

CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    data_horario DATETIME NOT NULL,
    placa_veiculo VARCHAR(10) DEFAULT NULL,
    observacoes TEXT DEFAULT NULL,
    status ENUM('pré-agendado', 'confirmado', 'cancelado') 
           DEFAULT 'pré-agendado',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Relacionamento com clientes
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
        ON DELETE CASCADE
);

-- ------------------------------
-- 4. Dados iniciais (OPCIONAL)
-- Inserções para facilitar os testes
-- ------------------------------

INSERT INTO clientes (tipo_pessoa, nome, cpf, telefone, email)
VALUES 
('PF', 'João da Silva', '123.456.789-00', '11999999999', 'joao@example.com'),
('PJ', 'Empresa XPTO LTDA', NULL, '11955555555', 'contato@xpto.com');

INSERT INTO agendamentos (cliente_id, data_horario, placa_veiculo, observacoes)
VALUES
(1, '2025-01-10 14:00:00', 'ABC1D23', 'Primeira vistoria'),
(2, '2025-01-12 09:30:00', NULL, 'Retorno de vistoria');
