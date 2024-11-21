<?php

    require_once 'db.php';

    function sanitizarEntrada($dado, $tipo = 'string'){
        if ($tipo == 'string'){
            return htmlspecialchars(trim($dado),ENT_QUOTES,'UTF-8');
        } else if ($tipo == 'inteiro'){
            return filter_var($dado,FILTER_SANITIZE_NUMBER_INT);
        } else if ($tipo == 'real'){
            return $filver_var($dado, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }
        return $dado;
    }

    function obterDados($nomeTabela, $criterios = [], $colunas = '*', $ordem = '', $limite = null){
    try {
        $conexao = conectarBD();

        if (!$conexao) {
            throw new Exception("Falha na conexão com o banco de dados");
        }

        // Monta a consulta SQL dinamicamente
        $consulta = "SELECT $colunas
                       FROM $nomeTabela";

        // Adiciona critérios de filtro (WHERE) dinamicamente
        if (!empty($criterios)) {
            $condicoes = [];
            foreach ($criterios as $coluna => $valor) {
                $condicoes[] = "$coluna = :$coluna";
                //Exemplo de resultado: nome = :nome, idade = :idade;
            }
            $consulta .= " WHERE " . implode(' AND ', $condicoes);
            //Exemplo de resultado: SELECT * FROM usuarios WHERE nome = :nome AND idade = :idade;
        }

        // Adiciona ordenação, se especificado
        if (!empty($ordem)) {
            $consulta .= " ORDER BY $ordem";
        }

        // Adiciona limite, se especificado
        if ($limite) {
            $consulta .= " LIMIT $limite";
        }

        $stmt = $conexao->prepare($consulta);

        // Associa os valores dos critérios ao prepared statement
        foreach ($criterios as $coluna => $valor) {
            $stmt->bindValue(":$coluna", $valor);
        }
        //$criterios = ['nome' => 'João', 'idade' => 25];
        //Exemplo de resultado FINAL: SELECT * FROM usuarios WHERE nome = 'João' AND idade = 25

        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta");
        }

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($dados)) {
            error_log("Nenhum registro encontrado na tabela $nomeTabela");
            return [];
        }

        return $dados;
    } catch (PDOException $e) {
        error_log("Erro PDO ao obter dados da tabela $nomeTabela: " . $e->getMessage());
        throw new Exception("Erro ao buscar os dados no banco de dados");
    } catch (Exception $e) {
        error_log("Erro ao obter dados da tabela $nomeTabela: " . $e->getMessage());
        throw new Exception("Erro ao processar os dados");
    } finally {
        // Fecha a conexão
        $conexao = null;
    }
}

function cadastrarItem($tabela, $dados, $secaoId){
    try {
        $conexao = conectarBD();

        if (!$conexao) {
            throw new Exception("Falha na conexão com o banco de dados");
        }

        $colunas = implode(", ", array_keys($dados));
        $placeholders = ":" . implode(", :", array_keys($dados));

        $sql = "INSERT INTO $tabela ($colunas) VALUES ($placeholders)";
        $stmt = $conexao->prepare($sql);

        $stmt->execute($dados);

        header('Location: ../public/admin.php#' . $secaoId);
        exit;

    } catch (PDOException $e) {
        echo("Erro ao inserir item: " . $e->getMessage());
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
            header('Location: ../public/admin.php#usuarios_administrativos');
            exit;
        } else {
            throw new Exception("Erro ao executar a consulta.");
        }


    } catch (PDOException $e) {
        echo "Erro ao cadastrar usuário: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['formulario'])) {
    $formulario = $_POST ['formulario']; 

    $dados = [];
    $tabela = '';
    $secaoId = '';

    switch($formulario){

        case 'perguntas':
            $tabela = 'PERGUNTAS';
            $secaoId = 'perguntas';
            $dados = [
                'texto' =>sanitizarEntrada($_POST['texto'],'string'),
                'ordem' =>sanitizarEntrada($_POST['ordem'],'inteiro'),
                'status' => TRUE
            ];
        break;  
        
        case 'setores':
            $tabela = 'setores';
            $secaoId = 'setores';
            $dados = [
                'nome' => sanitizarEntrada($_POST['nome'],'string')
            ];
        break;
        
        case 'dispositivos':
            $tabela = 'dispositivos';
            $secaoId = 'dispositivos';
            $dados = [
                'nome' => sanitizarEntrada($_POST['nome'],'string')
            ];
        break;

        case 'usuarios_administrativos':
            $tabela = 'usuarios_administrativos';
            $secaoId = 'usuarios_administrativos';
            $dados = [
                'login' => sanitizarEntrada($_POST['usuario'],'string'),
                'senha' => sanitizarEntrada($_POST['senha'],'string')
            ];
            cadastrarUsuario($dados['login'], $dados['senha']);
            return;
            break;
    }

    cadastrarItem($tabela, $dados, $secaoId);
    
}


if (isset($_GET['desativar']) && isset($_GET['tabela'])&& isset($_GET['secaoId'])) {
            
    try {

        $id = (int)$_GET['desativar'];
        $secaoId = $_GET['secaoId'];
        $tabela = $_GET['tabela'];
        
        $conexao = conectarBD();

        if (!$conexao) {
            throw new Exception("Falha na conexão com o banco de dados");
        }

        $query = "UPDATE $tabela
                     SET status = NOT STATUS
                   WHERE id = :id";
                   
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();

        $conexao = null;
        header('Location: ../public/admin.php#' . $secaoId);
        exit();

    } catch (PDOException $e) {

        echo 'Erro na conexão: ' . $e->getMessage();
    }
}


if (isset($_GET['remover']) && isset($_GET['tabela'])&& isset($_GET['secaoId'])) {
            
    try {

        $id = (int)$_GET['remover'];
        $secaoId = $_GET['secaoId'];
        $tabela = $_GET['tabela'];
        
        $conexao = conectarBD();

        if (!$conexao) {
            throw new Exception("Falha na conexão com o banco de dados");
        }

        $query = "DELETE FROM $tabela
                   WHERE id = :id";
                   
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();

        $conexao = null;
        header('Location: ../public/admin.php#' . $secaoId);
        exit();

    } catch (PDOException $e) {

        echo 'Erro na conexão: ' . $e->getMessage();
    }
}
    
    

    