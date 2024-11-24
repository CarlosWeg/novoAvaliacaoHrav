<?php

    require_once 'db.php';
    require_once 'funcoes.php';


    // Define a função que receberá os parâmetros para inserir a avaliação
    function inserirAvaliacao($setor_id, $pergunta_id, $dispositivo_id, $resposta, $feedback = null) {
        try {
            
            $conexao = conectarBD();
            
            if (!$conexao) {
                throw new Exception("Falha na conexão com o banco de dados");
            }

            // Validações dos dados recebidos, verifica se os IDs são números
            if (!is_numeric($setor_id) || !is_numeric($pergunta_id) || !is_numeric($dispositivo_id)) {
                throw new Exception("IDs inválidos fornecidos");
            }

            // Prepara a consulta SQL
            $consulta = "INSERT INTO avaliacoes (setor_id, pergunta_id, dispositivo_id, resposta, feedback) 
                        VALUES (?, ?, ?, ?, ?)";
            
            // Prepara a declaração SQL
            $stmt = $conexao->prepare($consulta);

            $resultado = $stmt->execute([
                $setor_id,
                $pergunta_id,
                $dispositivo_id,
                $resposta,
                $feedback
            ]);

            // Verifica se a inserção foi bem-sucedida
            // execute() retorna false se houver algum erro
            if (!$resultado) {
                throw new Exception("Erro ao inserir avaliação");
            }

        } catch (Exception $e){
            GerenciadorMensagens::tratarErro($e, '../public/index.php');
        } finally {
            // Fecha a conexão
            $conexao = null;
        }
    }
    
    // Função para processar as respostas do formulário
    function processarRespostas() {
        try {

            // Verifica se existem respostas
            if (isset($_POST['feedback'])) {
                $feedback_geral = sanitizarEntrada(($_POST['feedback']),'string');
            } else {
                $feedback_geral = null;
            }            
            
            $setor_id = sanitizarEntrada($_POST['setor_id'],'inteiro') ?? null;
            $dispositivo_id = sanitizarEntrada($_POST['dispositivo_id'],'inteiro') ?? null;

            if (!$setor_id || !$dispositivo_id) {
                throw new Exception("Setor ou dispositivo não selecionado.");
            }

            // Processa cada resposta
            foreach ($_POST['respostas'] as $pergunta_id => $resposta) {
                // Valida a resposta
                if (!is_numeric($resposta) || $resposta < 0 || $resposta > 10) {
                    throw new Exception("Resposta inválida para a pergunta $pergunta_id");
                }

                // Insere a avaliação
                inserirAvaliacao(
                    setor_id: $setor_id,
                    pergunta_id: $pergunta_id,
                    dispositivo_id: $dispositivo_id,
                    resposta: $resposta,
                    feedback: $feedback_geral
                );
            }

            header('Location: ../public/obrigado.php');
            exit;

        } catch (Exception $e){
            GerenciadorMensagens::tratarErro($e, '../public/index.php');
        } finally {
            // Fecha a conexão
            $conexao = null;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        processarRespostas();
    };