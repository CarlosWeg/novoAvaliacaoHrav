CREATE TABLE setores (
    id SERIAL PRIMARY KEY,                               -- ID do setor (PK)
    nome VARCHAR(100) NOT NULL,                          -- Nome do setor (obrigatório)
    status BOOLEAN DEFAULT TRUE                          -- Status (ativo/inativo, valor padrão: ativo)
);


CREATE TABLE perguntas (
    id SERIAL PRIMARY KEY,                               -- ID da pergunta (PK)
    texto TEXT NOT NULL,               		         -- Texto da pergunta (obrigatório)
    ordem INT NOT NULL,               		         -- Ordem de exibição (obrigatório)
    status BOOLEAN DEFAULT TRUE                          -- Status (ativa/inativa, valor padrão: ativa)
);


CREATE TABLE dispositivos (
    id SERIAL PRIMARY KEY,                               -- ID do dispositivo (PK)
    nome VARCHAR(100) NOT NULL,                          -- Nome do dispositivo (obrigatório)
    status BOOLEAN DEFAULT TRUE                          -- Status (ativo/inativo, valor padrão: ativo)
);


CREATE TABLE avaliacoes (
    id SERIAL PRIMARY KEY,                               -- ID da avaliação (PK)
    setor_id INT REFERENCES setores(id),                 -- ID do setor (FK)
    pergunta_id INT REFERENCES perguntas(id),            -- ID da pergunta (FK)
    dispositivo_id INT REFERENCES dispositivos(id),      -- ID do dispositivo (FK)
    resposta INT CHECK(resposta BETWEEN 0 AND 10),       -- Resposta (obrigatório, de 0 a 10)
    feedback TEXT,                                       -- Feedback textual (opcional)
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP        -- Data/Hora da avaliação (obrigatório, valor padrão: data/hora atuais)
);


CREATE TABLE usuarios_administrativos (
    id SERIAL PRIMARY KEY,                               -- ID do usuário (PK)
    login VARCHAR(50) NOT NULL UNIQUE,                   -- Login (obrigatório e único)
    senha VARCHAR(255) NOT NULL,                         -- Senha (obrigatório)
    status BOOLEAN DEFAULT TRUE                          -- Status (ativo/inativo, valor padrão: ativo)
);
