<?php

    require_once '../src/auth.php';
    require_once '../src/respostas.php';
    require_once '../src/funcoes.php';

    verificarAutenticacao();

    $perguntas = obterDados('PERGUNTAS',[],'ID,ORDEM,TEXTO,STATUS','ORDEM ASC');
    $respostas = obterDados('AVALIACOES',[],'*','DATA_HORA DESC');
    $usuarios = obterDados('USUARIOS_ADMINISTRATIVOS',[],'ID,LOGIN,STATUS','ID ASC');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Admin - Avaliação HRAV</title>
    <link rel="stylesheet" href="css/admin-estilos.css">
</head>
<body>

    <header>
        <nav class = "paginas_cabecalho">
                <a href = "#perguntas">Perguntas</a>
                <a href = "#respostas">Respostas</a>
                <a href = "#usuarios_administrativos">Usuarios Administrativos</a>
                <a href="../src/auth.php?logout=true">Sair</a>
        </nav>
    </header>


    <section id = "perguntas">
        <h3>Perguntas</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Texto</th>
                <th>Ordem</th>
                <th>Status</th>
                <th colspan = "2">Ações</th>
            </tr>

            
                <?php
                    foreach ($perguntas as $pergunta){
                        echo '<tr>';
                        echo '<td>' . $pergunta['id'] .'</td>';
                        echo '<td>' . $pergunta['texto'] .'</td>';
                        echo '<td>' . $pergunta['ordem'] .'</td>';
                        echo '<td>' . ($pergunta['status'] ? 'Ativo' : 'Inativo') . '</td>';
                        echo '<td><a href="../src/funcoes.php?tabela=perguntas&desativar=' . $pergunta['id'] . '">' . ($pergunta['status'] ? 'Inativar' : 'Ativar') . '</a></td>';
                        echo '</tr>';
                    }

                ?>

        </table>

    </section>

    <section id = "respostas">
        <h3>Respostas</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Setor ID</th>
                <th>Pergunta ID</th>
                <th>Dispositivo ID</th>
                <th>Resposta / Avaliação</th>
                <th>Feedback (opcional)</th>
                <th>Data / Hora</th>
            </tr>

            
                <?php
                    foreach ($respostas as $resposta){
                        echo '<tr>';
                        echo '<td>' . $resposta['id'] .'</td>';
                        echo '<td>' . $resposta['setor_id'] .'</td>';
                        echo '<td>' . $resposta['pergunta_id'] .'</td>';
                        echo '<td>' . $resposta['dispositivo_id'] .'</td>';
                        echo '<td>' . $resposta['resposta'] .'</td>';
                        echo '<td>' . $resposta['feedback'] .'</td>';
                        echo '<td>' . $resposta['data_hora'] .'</td>';
                        echo '</tr>';
                    }

                ?>

        </table>

    </section>

    <section id = "usuarios_administrativos">
        <h3>Usuários Administrativos</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            
                <?php
                    foreach ($usuarios as $usuario){
                        echo '<tr>';
                        echo '<td>' . $usuario['id'] .'</td>';
                        echo '<td>' . $usuario['login'] .'</td>';
                        echo '<td>' . ($usuario['status'] ? 'Ativo' : 'Inativo') . '</td>';
                        echo '<td><a href="../src/funcoes.php?tabela=usuarios_administrativos&desativar=' . $usuario['id'] . '">' . ($usuario['status'] ? 'Inativar' : 'Ativar') . '</a></td>';
                        echo '</tr>';
                    }

                ?>

        </table>

        <a href="../src/auth.php?logout=true">Sair</a>

    </section>




</body>