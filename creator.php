<?php

    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);

    class Creator {
        private $con;
        private $servidor ;
        private $banco;
        private $usuario;
        private $senha;
        private $tabelas;

        function __construct() {
            $this->conectar();
            $this->criaDiretorios();
            $this->buscaTabelas();
            $this->ClassesModel();
            $this->ClasseConexao();
            $this->ClassesControl();
        }

        function criaDiretorios() {
            $dirs = [
                "sistema",
                "sistema/model",
                "sistema/control",
                "sistema/view",
                "sistema/dao"
            ];

            foreach ($dirs as $dir) {
                if (!file_exists($dir)) {
                    if (!mkdir($dir, 0777, true)) {
                        header("Location:index.php?msg=0");
                    }
                }
            }
        }

        function conectar() {
            $this->servidor = $_POST["servidor"];
            $this->banco = $_POST["banco"];
            $this->usuario = $_POST["usuario"];
            $this->senha = $_POST["senha"];

            try {
                $this->con = new PDO(
                    "mysql:host=" . $this->servidor . ";dbname=" . $this->banco,
                    $this->usuario,
                    $this->senha
                );
            } catch (Exception $e) {
                header("Location:index.php?msg=1");
            }
        }

        function criaClasseConexao(){
            $conteudo = <<<EOT
                <?php
                    class Conexao {

                        private \$server;
                        private \$banco;
                        private \$usuario;
                        private \$senha;

                        function __construct() {
                            \$this->server = "[Informe aqui o Servidor]";
                            \$this->banco = "[Informe aqui o seu Banco de Dados]";
                            \$this->usuario = "[Informe aqui o usuário do Banco de Dados]";
                            \$this->senha = "[Informe aqui a senha do Banco de Dados]";
                        }

                        function conectar() {
                            try {
                                \$conn = new PDO(
                                    "mysql:host" . \$this->server . ";dbname=" . \$this->banco,\$this->usuario, \$this->senha
                                    );
                                    return \$conn;
                                } catch (Exception \$e) {
                                    echo "Erro ao conectar com o Banco de Dados: " . \$e->getMessage();
                                }
                            }
                        }
                ?>
                EOT;

                file_put_contents("sistema/model/conexao.php", $conteudo);
        }

        function ClassesModel() {
            if (!file_exists("sistema")) {
                mkdir("sistema");
            if (!file_exists("sistema/model"))
                mkdir("sistema/model");
            }
            $sql = "SHOW TABLES";
            $query = $this->con->query($sql);
            $tabelas = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($tabelas as $tabela) {
                $nomeTabela = array_values((array) $tabela)[0];
                $sql="show columns from ".$nomeTabela;
                $atributos = $this->con->query($sql)->fetchAll(PDO::FETCH_OBJ);
                $nomeAtributos="";
                $geters_seters="";
                foreach ($atributos as $atributo) {
                    $atributo=$atributo->Field;
                    $nomeAtributos.="\tprivate \${$atributo};\n";
                    $metodo=ucfirst($atributo);
                    $geters_seters.="\tfunction get".$metodo."(){\n";
                    $geters_seters.="\t\treturn \$this->{$atributo};\n\t}\n";
                    $geters_seters.="\tfunction set".$metodo."(\${$atributo}){\n";
                    $geters_seters.="\t\t\$this->{$atributo}=\${$atributo};\n\t}\n";
                }
                $nomeTabela=ucfirst($nomeTabela);

                $conteudo = <<<EOT
                    <?php
                        class {$nomeTabela} {
                            {$nomeAtributos}
                            {$geters_seters}
                        }
                    ?>
                EOT;
                
            file_put_contents("sistema/model/{$nomeTabela}.php", $conteudo);

            }
        }

        function buscaTabelas() {
            $sql = "SHOW TABLES";
            $query = $this->con->query($sql);
            $this->tabelas = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        function buscaAtributos($nomeTabela) {

        }

        function ClasseConexao() {

        }

        function ClassesControl() {
            foreach ($this->tabelas as $tabela) {
                $nomeTabela = ucfirst(array_values($tabela)[0]);
                    $conteudo = 
                    <<<EOT
                        <?php
                            require_once ("../model/$nomeTabela.php");
                            require_once ("../dao/{$nomeTabela}Dao.php");
                            class {$nomeTabela}Control {

                                private $model;
                                private $acao;
                                private $dao;

                                public function __construct() {
                                    $this->model = new $nomeTabela();
                                    $this->dao = new {$nomeTabela}Dao();
                                    $this->acao = $_GET[a];
                                    $this->verificaAcao();
                                }

                                function verificaAcao() {
                                    
                                }

                                function inserir() {}
                                function excluir() {}
                                function alterar() {}
                                function buscarId($nomeTabela $model) {}
                                function buscaTodos() {}
                            }
                            new {$nomeTabela}Control();
                            ?>
EOT;

            file_put_contents("sistema/control/{$nomeTabela}Control.php", $conteudo);
            }
        }
    }
    
new Creator();