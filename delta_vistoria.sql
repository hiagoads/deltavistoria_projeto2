-- ============================================================
-- BANCO DE DADOS: delta_vistoria - VERSÃO SIMPLIFICADA
-- Apenas admin gerencia tudo
-- ============================================================

CREATE DATABASE IF NOT EXISTS delta_vistoria
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE delta_vistoria;

-- ------------------------------
-- TABELA CLIENTES (mantida para cadastro)
-- ------------------------------
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_pessoa ENUM('PF', 'PJ') NOT NULL DEFAULT 'PF',
    nome VARCHAR(150) NOT NULL,
    cpf VARCHAR(14) NULL,
    cnpj VARCHAR(18) NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL,
    endereco TEXT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------
-- TABELA USUÁRIOS (apenas admin)
-- ------------------------------
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(150) NOT NULL DEFAULT 'Administrador',
    ativo TINYINT(1) DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------
-- TABELA AGENDAMENTOS (admin gerencia)
-- ------------------------------
CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    data_horario DATETIME NOT NULL,
    placa_veiculo VARCHAR(10) DEFAULT NULL,
    tipo_veiculo VARCHAR(50) DEFAULT NULL,
    observacoes TEXT DEFAULT NULL,
    status ENUM('agendado', 'confirmado', 'realizado', 'cancelado') DEFAULT 'agendado',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
);

-- ------------------------------
-- DADOS INICIAIS
-- ------------------------------

-- Apenas usuários admin (senha: senha123)
INSERT INTO usuarios (email, senha, nome) VALUES 
('admin@deltavistoria.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador Principal'),
('gerente@deltavistoria.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Gerente');

-- Clientes de exemplo
INSERT INTO clientes (tipo_pessoa, nome, cpf, telefone, email, endereco) VALUES 
('PF', 'João Silva', '123.456.789-00', '(11) 99999-9999', 'joao.silva@email.com', 'Rua A, 123 - São Paulo/SP'),
('PF', 'Maria Santos', '987.654.321-00', '(11) 88888-8888', 'maria.santos@email.com', 'Av. B, 456 - Rio de Janeiro/RJ'),
('PJ', 'Empresa XYZ LTDA', '12.345.678/0001-90', '(11) 77777-7777', 'contato@xyz.com', 'Rua Comercial, 789 - Campinas/SP');

-- Agendamentos de exemplo
INSERT INTO agendamentos (cliente_id, data_horario, placa_veiculo, tipo_veiculo, observacoes, status) VALUES
(1, '2024-02-01 09:00:00', 'ABC1D23', 'Carro Passeio', 'Vistoria completa - primeiro agendamento', 'confirmado'),
(2, '2024-02-01 14:30:00', 'XYZ9A87', 'Moto', 'Vistoria para transferência', 'agendado'),
(3, '2024-02-02 10:00:00', 'DEF5G67', 'Caminhão', 'Vistoria frota empresarial', 'agendado'),
(1, '2024-02-03 11:00:00', 'HIJ2K34', 'Carro Passeio', 'Segunda vistoria - veículo novo', 'confirmado');

-- Tabela para logs de acesso (opcional)
CREATE TABLE IF NOT EXISTS logs_acesso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    ip VARCHAR(45),
    user_agent TEXT,
    acesso_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);