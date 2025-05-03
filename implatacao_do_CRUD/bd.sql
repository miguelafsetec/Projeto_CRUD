-- Certifique-se de que o banco de dados 'cadastropessoa' não exista ou esteja vazio antes de executar.
-- DROP DATABASE IF EXISTS cadastropessoa; -- CUIDADO: Apaga o banco existente!

CREATE DATABASE IF NOT EXISTS cadastropessoa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE cadastropessoa;

-- Tabela pessoa (Necessária para a chave estrangeira da agenda)
-- Se você já tem essa tabela do projeto 'sistemapessoa', não precisa recriá-la.
CREATE TABLE IF NOT EXISTS pessoa (
    cpf CHAR(14) NOT NULL PRIMARY KEY COMMENT 'CPF formatado XXX.XXX.XXX-XX ou apenas números',
    nome VARCHAR(100) NOT NULL,
    contato CHAR(15) COMMENT 'Telefone com DDD e possível máscara (XX) XXXXX-XXXX'
    -- Adicione outros campos se necessário (email, endereco, etc.)
);

-- Tabela agenda (Depende da tabela pessoa)
CREATE TABLE IF NOT EXISTS agenda (
    codigo INT PRIMARY KEY AUTO_INCREMENT,
    cpf CHAR(14) NOT NULL COMMENT 'Deve corresponder a um CPF existente na tabela pessoa',
    data DATE NOT NULL COMMENT 'Data do compromisso',
    descricao VARCHAR(255) NOT NULL COMMENT 'Descrição do compromisso', -- Aumentei para 255 caracteres
    FOREIGN KEY (cpf) REFERENCES pessoa(cpf)
        ON DELETE CASCADE -- Se a pessoa for excluída, seus compromissos também serão.
        ON UPDATE CASCADE -- Se o CPF da pessoa for atualizado (raro, mas possível), atualiza aqui também.
);

-- Índices podem melhorar a performance de consulta (opcional, mas recomendado)
CREATE INDEX idx_agenda_data ON agenda(data);
CREATE INDEX idx_agenda_cpf ON agenda(cpf); -- Já existe pela FK, mas pode ser explícito.

-- Inserir dados de exemplo na tabela pessoa (se ela estiver vazia)
-- Remova a formatação do CPF se for armazenar apenas números
INSERT INTO pessoa (cpf, nome, contato) VALUES
('111.222.333-44', 'João da Silva', '(11) 98765-4321')
ON DUPLICATE KEY UPDATE nome=VALUES(nome), contato=VALUES(contato); -- Evita erro se CPF já existe

INSERT INTO pessoa (cpf, nome, contato) VALUES
('555.666.777-88', 'Maria Oliveira', '(21) 91234-5678')
ON DUPLICATE KEY UPDATE nome=VALUES(nome), contato=VALUES(contato);

-- Inserir dados de exemplo na tabela agenda (após inserir as pessoas)
INSERT INTO agenda (cpf, data, descricao) VALUES
('111.222.333-44', CURDATE() + INTERVAL 1 DAY, 'Reunião de equipe às 10h'),
('555.666.777-88', CURDATE() + INTERVAL 2 DAY, 'Consulta médica Dr. Carlos');