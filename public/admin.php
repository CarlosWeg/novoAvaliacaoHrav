<?php

    require_once '../src/auth.php';
    require_once '../src/respostas.php';
    require_once '../src/funcoes.php';

    verificarAutenticacao();

    $perguntas = obterDados('PERGUNTAS',[],'ID,ORDEM,TEXTO,STATUS','ORDEM ASC');
    $respostas = obterDados('AVALIACOES',[],'*','DATA_HORA DESC');
    $usuarios = obterDados('USUARIOS_ADMINISTRATIVOS',[],'ID,LOGIN,STATUS','ID ASC');
    $setores = obterDados('SETORES',[], '*', 'ID ASC');
    $dispositivos = obterDados('DISPOSITIVOS',[], '*', 'ID ASC');

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
                <a href = "#setores">Setores</a>
                <a href = "#dispositivos">Dispositivos</a>
                <a href = "#usuarios_administrativos">Usuários Administrativos</a>
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
                <th>Ações</th>
            </tr>
            
                <?php
                    foreach ($perguntas as $pergunta){
                        echo '<tr>';
                        echo '<td>' . $pergunta['id'] .'</td>';
                        echo '<td>' . $pergunta['texto'] .'</td>';
                        echo '<td>' . $pergunta['ordem'] .'</td>';
                        echo '<td>' . ($pergunta['status'] ? 'Ativo' : 'Inativo') . '</td>';
                        echo '<td><a href="../src/funcoes.php?tabela=perguntas&secaoId=perguntas&desativar=' . $pergunta['id'] . '">' . ($pergunta['status'] ? 'Inativar' : 'Ativar') . '</a></td>';
                        echo '</tr>';
                    }

                ?>

        </table>

        <form id = "cadastrar-pergunta" method = "POST" action = "../src/funcoes.php">
            <label for = "texto">Informe a pergunta</label>
            <input type = "text" name = "texto" required>

            <label for = "ordem">Informe a ordem:</label>
            <input type = "number" name = "ordem" required>
            
            <input type = "hidden" name = "formulario" value = "perguntas">
            <input type = "submit" value = "Cadastrar">

        </form>

    </section>

    <section id = "setores">
        <h3>Setores</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            
                <?php
                    foreach ($setores as $setor){
                        echo '<tr>';
                        echo '<td>' . $setor['id'] .'</td>';
                        echo '<td>' . $setor['nome'] .'</td>';
                        echo '<td>' . ($setor['status'] ? 'Ativo' : 'Inativo') . '</td>';
                        echo '<td><a href="../src/funcoes.php?tabela=setores&secaoId=setores&desativar=' . $setor['id'] . '">' . ($setor['status'] ? 'Inativar' : 'Ativar') . '</a></td>';
                        echo '</tr>';
                    }

                ?>

        </table>

        <form id = "cadastrar-setor" method = "POST" action = "../src/funcoes.php">
            <label for = "nome">Informe o NOME do setor:</label>
            <input type = "text" name = "nome" required>
            
            <input type = "hidden" name = "formulario" value = "setores">
            <input type = "submit" value = "Cadastrar">
        </form>  


    </section>

    <section id = "dispositivos">
        <h3>Dispositivos</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            
                <?php
                    foreach ($dispositivos as $dispositivo){
                        echo '<tr>';
                        echo '<td>' . $dispositivo['id'] .'</td>';
                        echo '<td>' . $dispositivo['nome'] .'</td>';
                        echo '<td>' . ($dispositivo['status'] ? 'Ativo' : 'Inativo') . '</td>';
                        echo '<td><a href="../src/funcoes.php?tabela=dispositivos&secaoId=dispositivos&desativar=' . $dispositivo['id'] . '">' . ($dispositivo['status'] ? 'Inativar' : 'Ativar') . '</a></td>';
                        echo '</tr>';
                    }

                ?>

        </table>

        <form id = "cadastrar-dispositivos" method = "POST" action = "../src/funcoes.php">
            <label for = "nome">Informe o NOME do dispositivo:</label>
            <input type = "text" name = "nome" required>
            
            <input type = "hidden" name = "formulario" value = "dispositivos">
            <input type = "submit" value = "Cadastrar">
        </form>  

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
                        echo '<td><a href="../src/funcoes.php?tabela=usuarios_administrativos&secaoId=usuarios_administrativos&desativar=' . $usuario['id'] . '">' . ($usuario['status'] ? 'Inativar' : 'Ativar') . '</a></td>';
                        echo '</tr>';
                    }

                ?>

        </table>


        <form id = "cadastrar-usuarios_administrativos" method = "POST" action = "../src/funcoes.php">
            <label for = "usuario">Informe o usuario:</label>
            <input type = "text" name = "usuario" required>

            <label for = "senha">Informe a senha:</label>
            <input type = "password" name = "senha" required>
            
            <input type = "hidden" name = "formulario" value = "usuarios_administrativos">
            <input type = "submit" value = "Cadastrar">
        </form>  


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

    <a href="../src/auth.php?logout=true">Sair</a>


</body>