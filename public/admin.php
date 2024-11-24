<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once '../src/GerenciadorMensagem.php';
    require_once '../src/auth.php';
    require_once '../src/respostas.php';
    require_once '../src/funcoes.php';

    verificarAutenticacao();
    $filtros = verificarFiltros();
    GerenciadorMensagem::exibirMensagem();
    
    $perguntas = obterDados('PERGUNTAS',[],'ID,ORDEM,TEXTO,STATUS','ORDEM ASC');
    $respostas = obterDados('AVALIACOES', $filtros, '*', 'DATA_HORA DESC');
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
    <link rel="icon" href="css/img/hrav-icon.png" type="image/png">
    <script src="js/scripts.js"></script>
</head>
<body>

    <header>
        <nav class = "paginas_cabecalho">
                <a href = "#perguntas">Perguntas</a>
                <a href = "#setores">Setores</a>
                <a href = "#dispositivos">Dispositivos</a>
                <a href = "#usuarios_administrativos">Usuários Administrativos</a>
                <a href = "#respostas">Respostas</a>
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
                        echo '<td><a href="../src/funcoes.php?tabela=perguntas&secaoId=perguntas&desativar=' . $pergunta['id'] . '">' . ($pergunta['status'] ? 'Inativar' : 'Ativar') . '</a></td>';
                        echo '<td><a href="../src/funcoes.php?tabela=perguntas&secaoId=perguntas&remover=' . $pergunta['id'] . '" onclick="return confirm(\'Tem certeza que deseja remover este item?\')">Remover</a></td>';
                        echo '</tr>';
                    }

                ?>

        </table>

        <form id = "cadastrar-pergunta" method = "POST" action = "../src/funcoes.php">
            <label for = "texto">Informe a pergunta:</label>
            <input class = "input-info" type = "text" name = "texto" required>

            <label for = "ordem">Informe a ordem:</label>
            <input class = "input-info"  type = "number" name = "ordem" required>
            
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
                <th colspan = "2">Ações</th>
            </tr>
            
                <?php
                    foreach ($setores as $setor){
                        echo '<tr>';
                        echo '<td>' . $setor['id'] .'</td>';
                        echo '<td>' . $setor['nome'] .'</td>';
                        echo '<td>' . ($setor['status'] ? 'Ativo' : 'Inativo') . '</td>';
                        echo '<td><a href="../src/funcoes.php?tabela=setores&secaoId=setores&desativar=' . $setor['id'] . '">' . ($setor['status'] ? 'Inativar' : 'Ativar') . '</a></td>';
                        echo '<td><a href="../src/funcoes.php?tabela=setores&secaoId=setores&remover=' . $setor['id'] . '" onclick="return confirm(\'Tem certeza que deseja remover este item?\')">Remover</a></td>';
                    }

                ?>

        </table>

        <form id = "cadastrar-setor" method = "POST" action = "../src/funcoes.php">
            <label for = "nome">Informe o nome do setor:</label>
            <input  class = "input-info" type = "text" name = "nome" required>
            
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
                <th colspan = "2">Ações</th>
            </tr>
            
                <?php
                    foreach ($dispositivos as $dispositivo){
                        echo '<tr>';
                        echo '<td>' . $dispositivo['id'] .'</td>';
                        echo '<td>' . $dispositivo['nome'] .'</td>';
                        echo '<td>' . ($dispositivo['status'] ? 'Ativo' : 'Inativo') . '</td>';
                        echo '<td><a href="../src/funcoes.php?tabela=dispositivos&secaoId=dispositivos&desativar=' . $dispositivo['id'] . '">' . ($dispositivo['status'] ? 'Inativar' : 'Ativar') . '</a></td>';
                        echo '<td><a href="../src/funcoes.php?tabela=dispositivos&secaoId=dispositivos&remover=' . $dispositivo['id'] . '" onclick="return confirm(\'Tem certeza que deseja remover este item?\')">Remover</a></td>';
                        echo '</tr>';
                    }

                ?>

        </table>

        <form id = "cadastrar-dispositivos" method = "POST" action = "../src/funcoes.php">
            <label for = "nome">Informe o nome do dispositivo:</label>
            <input  class = "input-info" type = "text" name = "nome" required>
            
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
                <th colspan = "2">Ações</th>
            </tr>
            
                <?php
                    foreach ($usuarios as $usuario){
                        echo '<tr>';
                        echo '<td>' . $usuario['id'] .'</td>';
                        echo '<td>' . $usuario['login'] .'</td>';
                        echo '<td>' . ($usuario['status'] ? 'Ativo' : 'Inativo') . '</td>';
                        echo '<td><a href="../src/funcoes.php?tabela=usuarios_administrativos&secaoId=usuarios_administrativos&desativar=' . $usuario['id'] . '">' . ($usuario['status'] ? 'Inativar' : 'Ativar') . '</a></td>';
                        echo '<td><a href="../src/funcoes.php?tabela=usuarios_administrativos&secaoId=usuarios_administrativos&remover=' . $usuario['id'] . '" onclick="return confirm(\'Tem certeza que deseja remover este item?\')">Remover</a></td>';
                        echo '</tr>';
                    }

                ?>

        </table>


        <form id = "cadastrar-usuarios_administrativos" method = "POST" action = "../src/funcoes.php">
            <label for = "usuario">Informe o usuário:</label>
            <input  class = "input-info" type = "text" name = "usuario" required>

            <label for = "senha">Informe a senha:</label>
            <input  class = "input-info" type = "password" name = "senha" required>
            
            <input type = "hidden" name = "formulario" value = "usuarios_administrativos">
            <input type = "submit" value = "Cadastrar">
        </form>  


    </section>

    <section id = "respostas">
        <h3>Respostas</h3>

        <form method = "GET" action = "#respostas" id = "form-filtros">

                <label for = "setor_id">Setor:</label>
                <select name = "setor_id">
                    <option value = "">Todos</option>
                    <?php
                        foreach ($setores as $setor){
                            echo '<option value = "' . $setor['id'] . '"';
                            if (isset($_GET['setor_id']) && $_GET ['setor_id'] == $setor['id']){
                                echo ' selected';
                            }
                            echo '>' . $setor['nome'] . '</option>';
                        }
                    ?>
                </select>

                
                <label for = "dispositivo_id">Dispositivo:</label>
                <select name = "dispositivo_id">
                    <option value = "">Todos</option>
                    <?php
                        foreach ($dispositivos as $dispositivo){
                            echo '<option value = "' . $dispositivo['id'] . '"';
                            if (isset($_GET['dispositivo_id']) && $_GET['dispositivo_id'] == $dispositivo['id']){
                                echo ' selected';
                            }
                            echo '>' . $dispositivo['nome'] . '</option>';
                        }
                    ?>
                </select>

                <label for = "pergunta_id">Pergunta:</label>
                <select name = "pergunta_id">
                    <option value = "">Todas</option>
                    <?php
                        foreach ($perguntas as $pergunta){
                            echo '<option value = "' . $pergunta['id'] . '"';
                            if (isset($_GET['pergunta_id']) && $_GET['pergunta_id'] == $pergunta['id']){
                                echo ' selected';
                            }
                            echo '>'. $pergunta['texto'] . '</option>';
                        }

                    ?>
                </select>

                <label for = "data_inicio">Data Início:</label>
                <input  class = "input-info" type = "date" name = "data_inicio"
                value = "<?php
                            if (isset($_GET['data_inicio'])){
                                echo $_GET['data_inicio'];
                            } else{
                                echo '';
                            }
                ?>">

                <label for = "data_fim">Data Fim:</label>
                <input  class = "input-info" type = "date" name = "data_fim"
                value = "<?php
                            if (isset($_GET['data_fim'])){
                                echo $_GET['data_fim'];
                            } else{
                                echo'';
                            }
                ?>">

                <input  class = "input-info" type = "submit" value = "Filtrar">
                <a href = "#respostas" onclick = "document.getElementById('form-filtros').reset()" id = "limpar-filtros" >Limpar filtros</a>

        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Setor ID</th>
                <th>Pergunta ID</th>
                <th>Dispositivo ID</th>
                <th>Resposta / Avaliação</th>
                <th>Feedback (opcional)</th>
                <th>Data / Hora</th>
                <th>Ações</th>
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
                        echo '<td>' . date('d/m/Y H:i:s', strtotime($resposta['data_hora'])) .'</td>';
                        echo '<td><a href="../src/funcoes.php?tabela=avaliacoes&secaoId=respostas&remover=' . $resposta['id'] . '" onclick="return confirm(\'Tem certeza que deseja remover este item?\')">Remover</a></td>';
                        echo '</tr>';
                    }

                ?>

        </table>

    </section>


</body>