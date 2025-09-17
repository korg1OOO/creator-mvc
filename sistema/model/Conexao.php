<?php
class Conexao {
    private $server;
    private $banco;
    private $usuario;
    private $senha;
    function __construct() {
        $this->server = '127.0.0.1';
        $this->banco = 'pizzaria';
        $this->usuario = 'root';
        $this->senha = '';
    }
    function conectar() {
        try {
            $conn = new PDO(
                "mysql:host=" . $this->server . ";dbname=" . $this->banco,
                $this->usuario,
                $this->senha
            );
            return $conn;
        } catch (Exception $e) {
            echo "Erro ao conectar com o Banco de dados: " . $e->getMessage();
        }
    }
}
?>