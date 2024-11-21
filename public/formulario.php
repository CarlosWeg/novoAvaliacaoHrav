<?php

session_start();
require_once '../src/perguntas.php';
require_once '../src/funcoes.php';

$perguntas = obterDados('PERGUNTAS',['STATUS' => 'TRUE'],'ID,ORDEM,TEXTO,STATUS','ORDEM ASC');
$setor_id = $_SESSION['setor_id'];
$dispositivo_id = $_SESSION['dispositivo_id'];


if (!isset($dispositivo_id) || !isset($setor_id)){
    session_destroy();
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário - Avaliação HRAV</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="icon" href="css/img/hrav-icon.png" type="image/png">
    <script src="js/scripts.js"></script>
</head>
<body>

    <div class = "container-principal">

        <img src = "css/img/logo-white.png" alt = "Logo do Hospital" id = "logo-hospital">

        <h1>AVALIAÇÃO DE SERVIÇOS</h1>

        <form id="formulario" action="../src/respostas.php" method="POST">
            <input type="hidden" name="setor_id" value="<?=$setor_id;?>">
            <input type="hidden" name="dispositivo_id" value="<?=$dispositivo_id;?>">
                <!-- Loop que percorre cada pergunta do array $perguntas -->
                <?php foreach ($perguntas as $index => $pergunta): ?>
                    <div class="pergunta">
                        <label class = "pergunta-texto"><?=$pergunta['texto'];?></label>
                        <div class="escala">
                            <?php for ($i = 0; $i <= 10; $i++): ?>
                                <!--
                                    - id: identifica unicamente cada input (ex: resposta-1-5 para pergunta 1, valor 5)
                                    - name: agrupa os radios por pergunta (ex: respostas[1] para pergunta 1)
                                    - value: valor numérico da resposta (0 a 10)
                                !-->
                                <input type="radio" id="resposta-<?= $pergunta['id']; ?>-<?= $i; ?>" name="respostas[<?= $pergunta['id']; ?>]" value="<?= $i; ?>" required>
                                <label for="resposta-<?= $pergunta['id']; ?>-<?= $i; ?>" class="label-escala label-escala-<?= $i; ?>">
                                <?= $i; ?>
                                </label>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Feedback adicional aparece após as perguntas -->
                <div class="feedback-container">
                    <label for="feedback">Feedback adicional (opcional):</label><br>
                    <textarea name="feedback" id="feedback"></textarea>
                </div>

                <button type="button" id="botao-perguntas" onclick="proxPergunta()">PRÓXIMA</button>
                
            </form>

        <footer>
                <p>Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
        </footer>

    </div>

</body>


</html>