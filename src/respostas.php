<?php

    require_once 'db.php';
    require_once 'perguntas.php';


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

            // Cria um array com as verificações que precisam ser feitas, cada elemento contém o nome da tabela e o ID a ser verificado
            $verificacoes = [
                ['tabela' => 'setores', 'id' => $setor_id],
                ['tabela' => 'perguntas', 'id' => $pergunta_id],
                ['tabela' => 'dispositivos', 'id' => $dispositivo_id]
            ];

            // Loop para verificar se cada ID existe em sua respectiva tabela
            foreach ($verificacoes as $verificacao) {
                // Prepara a consulta SQL para verificar a existência do ID
                $consulta = "SELECT id FROM {$verificacao['tabela']} WHERE id = ?";
                $stmt = $conexao->prepare($consulta);
                $stmt->execute([$verificacao['id']]);
                
                // Se não encontrar o ID, lança uma exceção
                if (!$stmt->fetch()) {
                    throw new Exception("ID não encontrado na tabela {$verificacao['tabela']}");
                }
            }

            // Prepara a consulta SQL
            $consulta = "INSERT INTO avaliacoes (setor_id, pergunta_id, dispositivo_id, resposta, feedback) 
                        VALUES (?, ?, ?, ?, ?)";
            
            // Prepara a declaração SQL
            $stmt = $conexao->prepare($consulta);

            // Executa a consulta, substituindo os placeholders pelos valores reais
            $resultado = $stmt->execute([
                $setor_id,
                $pergunta_id,
                $dispositivo_id,
                $resposta,
                $feedback
            ]);

            // Verifica se a inserção foi bem-sucedida
            if (!$resultado) {
                throw new Exception("Erro ao inserir avaliação");
            }

        } catch (PDOException $e) {
            // Captura erros específicos do PDO (relacionados ao banco de dados)
            error_log("Erro PDO ao inserir avaliação: " . $e->getMessage());
            throw new Exception("Erro ao salvar a avaliação no banco de dados");
            
        } catch (Exception $e) {
            // Captura outros tipos de erros
            error_log("Erro ao inserir avaliação: " . $e->getMessage());
            throw new Exception($e->getMessage());
            
        } finally {
            $conexao = null;
        }
    }

    // Função para processar as respostas do formulário
    function processarRespostas() {
        try {
            // Verifica se o formulário foi enviado via POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Método inválido");
            }

            // Verifica se existem respostas
            if (!isset($_POST['respostas']) || !is_array($_POST['respostas'])) {
                throw new Exception("Nenhuma resposta fornecida");
            }

            // Pega o feedback (opcional)
            $feedback_geral = isset($_POST['feedback']) ? trim($_POST['feedback']) : null;

            $dispositivo_id = 1;
            $setor_id = 1;

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

            // Redireciona para uma página de sucesso
            header('Location: ../public/obrigado.php');
            exit;

        } catch (Exception $e) {
            // Log do erro
            error_log("Erro ao processar respostas: " . $e->getMessage());
            
            // Redireciona para página de erro
            header('Location: ../public/erro.php');
            exit;
        }
    }

    // Executa o processamento
    processarRespostas();