-- Apagar dados das tabelas, começando pelas tabelas com dependências
DELETE FROM avaliacoes;
DELETE FROM setores;
DELETE FROM perguntas;
DELETE FROM dispositivos;
DELETE FROM usuarios_administrativos;

-- Resetar as sequências dos IDs
TRUNCATE TABLE setores RESTART IDENTITY CASCADE;
TRUNCATE TABLE perguntas RESTART IDENTITY CASCADE;
TRUNCATE TABLE dispositivos RESTART IDENTITY CASCADE;
TRUNCATE TABLE avaliacoes RESTART IDENTITY CASCADE;
TRUNCATE TABLE usuarios_administrativos RESTART IDENTITY CASCADE;

-- Inserir setores
INSERT INTO setores (nome, status) VALUES 
('Emergência', TRUE),
('UTI', TRUE),
('Recepção', TRUE);

-- Inserir perguntas
INSERT INTO perguntas (texto, ordem, status) VALUES 
('Qual a sua satisfação geral com o atendimento?', 1, TRUE),
('A equipe foi atenciosa?', 2, TRUE),
('Os recursos disponíveis foram adequados?', 3, TRUE);

-- Inserir dispositivos
INSERT INTO dispositivos (nome, status) VALUES 
('Tablet - Recepção', TRUE),
('Tablet - Emergência', TRUE),
('Aplicativo Móvel', TRUE);

-- Inserir usuário
CREATE EXTENSION IF NOT EXISTS pgcrypto;
INSERT INTO usuarios_administrativos (login, senha)
VALUES ('admin', crypt('admin', gen_salt('bf')));