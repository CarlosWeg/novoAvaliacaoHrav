<?php
    require_once 'db.php';

    function obterPerguntas() {
        try {
            $conexao = conectarBD();
            
            if (!$conexao) {
                throw new Exception("Falha na conexão com o banco de dados");
            }
    
            // Consulta para obter as perguntas
            $consulta = "SELECT 
                            ID,
                            ORDEM,
                            TEXTO,
                            STATUS 
                        FROM PERGUNTAS 
                       WHERE STATUS = 'TRUE' 
                       ORDER BY ORDEM";
    
            $stmt = $conexao->prepare($consulta);
            
            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta");
            }
    
            $perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if (empty($perguntas)) {
                error_log("Nenhuma pergunta ativa encontrada no banco de dados");
                return [];
            }
    
            return $perguntas;
    
        } catch (PDOException $e) {
            error_log("Erro PDO ao obter perguntas: " . $e->getMessage());
            throw new Exception("Erro ao buscar as perguntas no banco de dados");
            
        } catch (Exception $e) {
            error_log("Erro ao obter perguntas: " . $e->getMessage());
            throw new Exception("Erro ao processar as perguntas");
        } finally {
            // Fecha a conexão
            $conexao = null;
        }
    }