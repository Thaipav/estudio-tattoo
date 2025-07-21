DROP DATABASE IF EXISTS estudio;
CREATE DATABASE estudio;
USE estudio;
CREATE TABLE IF NOT EXISTS clientes (
id_cliente INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(50) NOT NULL,
telefone VARCHAR(14),
email VARCHAR(50),
nascimento DATE,
observacoes TINYTEXT
);

CREATE TABLE agendas (
id_agenda INT AUTO_INCREMENT PRIMARY KEY,
id_cliente INT NOT NULL,
descricao_tatuagem  TINYTEXT,
tamanho DECIMAL(5,2),
local_corpo VARCHAR(30),
data_hora DATETIME,
status ENUM('Agendado', 'Concluido', 'Cancelado'),
observacoes TINYTEXT,
FOREIGN KEY (id_cliente) REFERENCES clientes (id_cliente)
);
CREATE TABLE pagamentos(
id_pagamento INT AUTO_INCREMENT PRIMARY KEY,
id_agenda INT NOT NULL,
valor_pago DECIMAL, 
forma_pagamento VARCHAR(50),
data_pagamento DATE,
observacoes TINYTEXT,
FOREIGN KEY (id_agenda) REFERENCES agendas (id_agenda)
);
SHOW TABLES;

INSERT INTO clientes (nome, telefone, email, nascimento, observacoes) VALUES
('Lucas Mendes', '11999998888', 'lucas@email.com', '1992-04-15', 'Alérgico a látex.'),
('Bruna Carvalho', '21988887777', 'bruna@email.com', '1995-06-22', 'Possui diabetes tipo 1.'),
('Pedro Silva', '31977776666', 'pedro@email.com', '1989-11-30', 'Sem alergias ou comorbidades.');

INSERT INTO agendas (id_cliente, descricao_tatuagem, tamanho, local_corpo, data_hora, status, observacoes) VALUES
(1, 'Rosa no braço', 10.5, 'Braço direito', '2025-07-25 14:00:00', 'Agendado', 'Cliente pediu desenho detalhado.'),
(2, 'Tribal nas costas', 20.0, 'Costas', '2025-07-28 10:00:00', 'Concluido', 'Nenhuma observação.'),
(3, 'Frase no pulso', 5.0, 'Pulso esquerdo', '2025-08-01 16:00:00', 'Cancelado', 'Cancelado por motivos pessoais.');

INSERT INTO pagamentos (id_agenda, valor_pago, forma_pagamento, data_pagamento, observacoes) VALUES
(1, 450.00, 'Pix', '2025-08-01', 'Pagamento integral na sessão'),
(2, 300.00, 'Cartão de Crédito', '2025-08-05', 'Parcelado em 2x'),
(2, 150.00, 'Cartão de Crédito', '2025-08-20', 'Segunda parcela'),
(3, 0.00, 'Nenhum', NULL, 'Sessão cancelada, sem pagamento');

