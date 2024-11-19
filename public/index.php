<?php

session_start();
require_once '../src/funcoes.php';
$setores = obterSetores();
$dispositivos = obterDispositivos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    <script src="js/scripts.js"></script>
</head>
<body>

    <div class="container-principal">

        <img src="css/img/logo-white.png" alt="Logo do Hospital" id="logo-hospital">

        <h1>Bem vindo(a) a pagina inicial do sistema de avaliações!</h1>
        <h3>Como gostaria de prosseguir?</h3>


        <div class = "selecao-formulario">
            <h3>Iniciar formulário</h3>
            <form id = "formulario-setor-dispositivo"  method = "POST">

                <h3>Selecione o setor:</h3>
                <select name="setor_id">
                
                        <?php foreach ($setores as $index=>$setor): ?>
                            <option value = "<?=$setor['id']?>"><?=$setor['nome']?></option>
                        <?php endforeach; ?>       


                </select>


                <h3>Selecione o dispositivo:</h3>
                <select name="dispositivo_id">
                
                        <?php foreach ($dispositivos as $index=>$dispositivo): ?>
                            <option value = "<?=$dispositivo['id']?>"><?=$dispositivo['nome']?></option>
                        <?php endforeach; ?>       

                </select>

                <button type="submit">Prosseguir para Avaliação</button>

            </form>
       
        </div>

        <div class = "autenticador-admin">

            <a href = "admin.php">Acessar painel de Administrador</a>

        </div>


    </div>


</body>

</html>