-- Remove o banco de dados "estudio" se ele já existir
DROP DATABASE IF EXISTS estudio;

-- Cria um novo banco de dados chamado "estudio"
CREATE DATABASE estudio;

-- Seleciona o banco de dados "estudio" para uso
USE estudio;

-- Criação da tabela de clientes
CREATE TABLE IF NOT EXISTS clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,      -- Identificador único do cliente
    nome VARCHAR(50) NOT NULL,                     
    telefone VARCHAR(14),                           
    email VARCHAR(50),                              
    nascimento DATE,                                
    observacoes TINYTEXT                            
);

-- Criação da tabela de agendamentos
CREATE TABLE agendas (
    id_agenda INT AUTO_INCREMENT PRIMARY KEY,       -- Identificador único do agendamento
    id_cliente INT NOT NULL,                        -- Referência ao cliente (chave estrangeira)
    descricao_tatuagem TINYTEXT,                    
    tamanho DECIMAL(5,2),                           
    local_corpo VARCHAR(30),                        
    data_hora DATETIME,                             
    status ENUM('Agendado', 'Concluido', 'Cancelado'), 
    observacoes TINYTEXT,                           
    FOREIGN KEY (id_cliente) REFERENCES clientes (id_cliente) -- Chave estrangeira ligando ao cliente
);

-- Criação da tabela de pagamentos
CREATE TABLE pagamentos (
    id_pagamento INT AUTO_INCREMENT PRIMARY KEY,    -- Identificador único do pagamento
    id_agenda INT NOT NULL,                         -- Referência ao agendamento (chave estrangeira)
    valor_pago DECIMAL,                           
    forma_pagamento VARCHAR(50),                   
    data_pagamento DATE,                            
    observacoes TINYTEXT,                          
    FOREIGN KEY (id_agenda) REFERENCES agendas (id_agenda) -- Relaciona pagamento a um agendamento
);

-- Exibe a lista de tabelas criadas no banco de dados
SHOW TABLES;

-- Insere dados fictícios na tabela de clientes
INSERT INTO clientes (nome, telefone, email, nascimento, observacoes) VALUES
('Lucas Mendes', '11999998888', 'lucas@email.com', '1992-04-15', 'Alérgico a látex.'),
('Bruna Carvalho', '21988887777', 'bruna@email.com', '1995-06-22', 'Possui diabetes tipo 1.'),
('Pedro Silva', '31977776666', 'pedro@email.com', '1989-11-30', 'Sem alergias ou comorbidades.');

-- Insere agendamentos relacionados aos clientes cadastrados
INSERT INTO agendas (id_cliente, descricao_tatuagem, tamanho, local_corpo, data_hora, status, observacoes) VALUES
(1, 'Rosa no braço', 10.5, 'Braço direito', '2025-07-25 14:00:00', 'Agendado', 'Cliente pediu desenho detalhado.'),
(2, 'Tribal nas costas', 20.0, 'Costas', '2025-07-28 10:00:00', 'Concluido', 'Nenhuma observação.'),
(3, 'Frase no pulso', 5.0, 'Pulso esquerdo', '2025-08-01 16:00:00', 'Cancelado', 'Cancelado por motivos pessoais.');

-- Insere registros de pagamentos realizados (ou não) para cada agendamento
INSERT INTO pagamentos (id_agenda, valor_pago, forma_pagamento, data_pagamento, observacoes) VALUES
(1, 450.00, 'Pix', '2025-08-01', 'Pagamento integral na sessão'),
(2, 300.00, 'Cartão de Crédito', '2025-08-05', 'Parcelado em 2x'),
(2, 150.00, 'Cartão de Crédito', '2025-08-20', 'Segunda parcela'),
(3, 0.00, 'Nenhum', NULL, 'Sessão cancelada, sem pagamento');

