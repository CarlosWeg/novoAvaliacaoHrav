<?php

function conectarBD(){
    try {
        $host = 'localhost'; // Nome do host
        $db = 'hospital_avaliacao'; // Nome do Banco de Dados
        $user = 'postgres'; // Nome Usuário
        $pass = 'postgres'; // Senha Usuário
        $port = '5432'; // Porta padrão PostgreSQL

        $dsn = "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$pass";

        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;

    } catch (PDOException $e) {
        error_log("Erro ao conectar: " . $e->getMessage());
        return null;
    }
}
