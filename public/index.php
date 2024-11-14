<?php
require_once '../src/funcoes.php';
$setores = obterSetores();
$dispositivos = obterDispositivos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $setor_id = $_POST['setor_id'];
    $dispositivo_id = $_POST['dispositivo_id'];
    header("Location: formulario.php?setor_id=$setor_id&dispositivo_id=$dispositivo_id");
    exit;
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

        <div class = "autenticador-admin">

            <a href = "admin.php">Acessar painel de Administrador</a>

    </div>

        <div class = "selecao-formulario">
            <form id = "formulario-setor-dispositivo"  method = "POST">

                <h4>Selecione o setor:</h4>
                <select name="setor_id">
                
                        <?php foreach ($setores as $index=>$setor): ?>
                            <option value = "<?=$setor['id']?>"><?=$setor['nome']?></option>
                        <?php endforeach; ?>       


                </select>

                <h4>Selecione o dispositivo:</h4>
                <select name="dispositivo_id">
                
                        <?php foreach ($dispositivos as $index=>$dispositivo): ?>
                            <option value = "<?=$dispositivo['id']?>"><?=$dispositivo['nome']?></option>
                        <?php endforeach; ?>       

                </select>

                <button type="submit">Prosseguir para Avaliação</button>

            </form>
       
        </div>

    </div>


</body>

</html>