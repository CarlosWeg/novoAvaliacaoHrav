<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db.php';
require_once 'funcoes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login']) && isset($_POST['senha'])){
    $login = sanitizarEntrada($_POST['login'],'string');
    $senha = sanitizarEntrada($_POST['senha'],'string');
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
        $pagina = '../public/admin.php';

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
        GerenciadorMensagem::definirMensagem('Usuário ' . $login . ' autenticado com sucesso!','sucesso',$pagina);

    } catch (Exception $e){
        GerenciadorMensagem::tratarErro($e, $pagina);
    }
}
function verificarAutenticacao() {
    if (!isset($_SESSION['usuario_logado'])) {
        header('Location: ../public/index.php');
        exit();
    }
}