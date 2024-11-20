<?php

    require_once 'db.php';

    function obterSetores(){
        try{
            $conexao = conectarBD();

            if (!$conexao){
                throw new Exception("Falha na conexão com o banco de dados");
            }

            $consulta = "SELECT *
                           FROM SETORES
                          WHERE STATUS = 'TRUE'
                         ORDER BY NOME ASC";

            $stmt = $conexao->prepare($consulta);

            if (!$stmt->execute()){
                throw new Exception("Erro ao executar a consulta");
            }

            $setores = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($setores)){
                error_log("Nenhum setor ativo encontrado no banco de dados");
                return [];
            }

            return $setores;

        } catch (PDOException $e) {
            error_log("Erro PDO ao obter setores: " . $e->getMessage());
            throw new Exception("Erro ao buscar as setores no banco de dados");
            
        } catch (Exception $e) {
            error_log("Erro ao obter setores: " . $e->getMessage());
            throw new Exception("Erro ao processar os setores");
        } finally {
            // Fecha a conexão
            $conexao = null;
        }
    }

    function obterDispositivos(){
        try{
            $conexao = conectarBD();

            if (!$conexao){
                throw new Exception("Falha na conexão com o banco de dados");
            }

            $consulta = "SELECT *
                           FROM DISPOSITIVOS
                          WHERE STATUS = 'TRUE'
                         ORDER BY NOME ASC";

            $stmt = $conexao->prepare($consulta);

            if (!$stmt->execute()){
                throw new Exception("Erro ao executar a consulta");
            }

            $dispositivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($dispositivos)){
                error_log("Nenhum dispositivo ativo encontrado no banco de dados");
                return [];
            }

            return $dispositivos;

        } catch (PDOException $e) {
            error_log("Erro PDO ao obter dispositivos: " . $e->getMessage());
            throw new Exception("Erro ao buscar as dispositivos no banco de dados");
            
        } catch (Exception $e) {
            error_log("Erro ao obter dispositivos: " . $e->getMessage());
            throw new Exception("Erro ao processar os dispositivos");
        } finally {
            // Fecha a conexão
            $conexao = null;
        }
    }

    function obterUsuarios(){
        try{
            $conexao = conectarBD();

            if (!$conexao){
                throw new Exception('Falha na conexão com o banco de dados');
            }

            $consulta = "SELECT ID, LOGIN, STATUS
                           FROM USUARIOS_ADMINISTRATIVOS
                          ORDER BY ID";

            $stmt = $conexao->prepare($consulta);

            if (!$stmt->execute()){
                throw new Exception("Erro ao executar a consulta");
            }

            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $usuarios;

        } catch (PDOException $e) {
            erro_log("Erro PDO ao obter usuários: " . $e->getMessage());
            throw new Exception('Erro ao buscar usuários no banco de dados');
        } catch (Exception $e) {
            error_log('Erro ao obter usuários: ' . $e->getMessage());
            throw new Exception('Erro ao processar os usuários');
        } finally{
            $conexao = null;
        }

    }

    
    

    