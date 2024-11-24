<?php

    class GerenciadorMensagem{
        private const TIPOS = ['sucesso','erro', 'aviso'];
        
        public static function definirMensagem($texto, $tipo = 'aviso',$pagina){
            
            $_SESSION['mensagemSistema'] = [
                'texto'=>$texto,
                'tipo'=>$tipo,
            ];

            header('Location: ' . $pagina);
            exit();
        }

        public static function exibirMensagem(){
            if (isset($_SESSION['mensagemSistema'])){
                $mensagem = $_SESSION['mensagemSistema'];
                self::renderizarMensagem($mensagem);
                unset($_SESSION['mensagemSistema']);
            }
        }

        private static function renderizarMensagem($mensagem) {
            $icones = [
                'sucesso' => '✓',
                'erro' => '✕',
                'aviso' => '⚠',
            ];

            $icone = $icones[$mensagem['tipo']];
            echo '<div id = "mensagemSistema" class = "mensagem-sistema">';
            echo '<span class = "icone-mensagem">' . $icone . '</span>';
            echo '<span class = "texto-mensagem">' . $mensagem['texto'] . '</span>';
            echo '</div>';
        }

        public static function tratarErro($e,$pagina){

            if ($e instanceof PDOException){
                switch($e->getCode()){
                    case '23503':
                        self::definirMensagem(
                            'Não foi possível excluir o item, pois ele está vinculado a outro registro.',
                            'erro',
                            $pagina
                        );
                        break;

                    case '23505':
                        self::definirMensagem(
                            'Este registro já existe no sistema.',
                            'erro',
                            $pagina
                        );
                    break;

                    default:
                    self::definirMensagem(
                        'Ocorreu um erro no banco de dados. Por favor, tente novamente.',
                        'erro',
                        $pagina
                    );
                    error_log('Erro PDO: ' . $e->getMessage());
                }
            } else{
                self::definirMensagem(
                    'Por favor, tente novamente.',
                    'erro',
                    $pagina
                );
                error_log('Erro não tratado: ' . $e->getMessage());
            }
            
            header('Location: ' . $pagina);
        } 


    }