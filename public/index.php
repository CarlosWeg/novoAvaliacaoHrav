<?php

require_once '../src/funcoes.php';
require_once '../src/GerenciadorMensagem.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

GerenciadorMensagem::exibirMensagem();
session_unset();

$setores = obterDados('SETORES',['STATUS' => 'TRUE'], '*', 'NOME ASC');
$dispositivos = obterDados('DISPOSITIVOS',['STATUS' => 'TRUE'], '*', 'NOME ASC');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setor_id']) && isset($_POST['dispositivo_id'])) {
    $setor_id = filter_input(INPUT_POST,'setor_id', FILTER_VALIDATE_INT);
    $dispositivo_id = filter_input(INPUT_POST,'dispositivo_id', FILTER_VALIDATE_INT);

    if ($setor_id && $dispositivo_id){
        $_SESSION['setor_id'] = $setor_id;
        $_SESSION['dispositivo_id'] = $dispositivo_id;
        header("Location: formulario.php");
        exit;
    }else{
        header("Location: erro.php");
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Incial - Avaliação HRAV</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="icon" href="css/img/hrav-icon.png" type="image/png">
    <script src="js/scripts.js"></script>
</head>
<body>

    <div class="container-principal">


        <h1>Bem vindo(a) a pagina inicial do sistema de avaliações!</h1>

        <div class = "container-formulario-inicial">
            <form id = "formulario-setor-dispositivo"  method = "POST">

                <h3>Selecione o setor:</h3>
                <select name="setor_id" required>
                
                        <?php foreach ($setores as $index=>$setor): ?>
                            <option value = "<?=$setor['id']?>"><?=$setor['nome']?></option>
                        <?php endforeach; ?>       


                </select>

                <h3>Selecione o dispositivo:</h3>
                <select name="dispositivo_id" required>
                
                        <?php foreach ($dispositivos as $index=>$dispositivo): ?>
                            <option value = "<?=$dispositivo['id']?>"><?=$dispositivo['nome']?></option>
                        <?php endforeach; ?>       

                </select>

                <button type="submit">Prosseguir para Avaliação</button>

            </form>
       
        </div>

        <hr>

        <div class = "container-formulario-inicial">

            <form id = "formulario-autenticador" method = "POST" action = "../src/auth.php">

                <label for = "login">Informe o usuario:</label>
                <input type = "text" name = "login" required>

                <label for = "senha">Informe a senha:</label>
                <input type = "password" name = "senha" required>

                <button type="submit">Prosseguir para Painel Admin</button>

            </form>


        </div>


    </div>


</body>

</html>