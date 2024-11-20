<?php

session_start();

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    login($login,$senha);
}

if (isset($_GET['logout'])){
    session_destroy();
    header('Location: ../public/index.php');
    exit();
}

function login($login,$senha){
    try{
        
        $conexao = conectarBD();

        if (!$conexao) {
            throw new Exception("Falha na conexão com o banco de dados");
        }

        $consulta = "SELECT id, senha
                       FROM usuarios_administrativos
                      WHERE login = :login
                        AND status = TRUE";

        $stmt = $conexao->prepare($consulta);
        $stmt->bindValue(':login', $login, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta");
        }

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$resultado) {
            throw new Exception("Usuário não encontrado ou inativo");
        }

        if (!password_verify($senha, $resultado['senha'])) {
            throw new Exception("Senha incorreta");
        }
        
        $_SESSION['usuario_logado'] = $resultado['id'];
        header('Location: ../public/admin.php');

    } catch (Exception $e) {
        error_log("Erro no login: " . $e->getMessage());
        throw new Exception("Falha no login: " . $e->getMessage());
    } finally {
        if (isset($conexao)) {
            $conexao = null;
        }
    }
}


function cadastrarUsuario($usuario, $senha) {
    try {

        $conexao = conectarBD();

        if (!$conexao) {
            throw new Exception("Falha na conexão com o banco de dados.");
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $query = "INSERT INTO usuarios_administrativos (login, senha) VALUES (:usuario, :senha)";

        $stmt = $conexao->prepare($query);

        // Vinculando os valores aos placeholders
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            throw new Exception("Erro ao executar a consulta.");
        }

    } catch (PDOException $e) {
        echo "Erro ao cadastrar usuário: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function verificarAutenticacao() {
    if (!isset($_SESSION['usuario_logado'])) {
        header('Location: ../public/index.php');
        exit();
    }
}