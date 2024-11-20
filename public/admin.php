<?php
    session_start();
    require_once '../src/auth.php';
    require_once '../src/perguntas.php';
    require_once '../src/respostas.php';

    verificarAutenticacao();

    $perguntas = obterPerguntas();
    $respostas = obterRespotas();

    foreach ($respostas as $resposta){
        echo $resposta;
    }

?>