<?php
require_once("../model/conexao.php");
class EstadoDao {
    private $con;
    public function __construct(){
       $this->con=(new Conexao())->conectar();
    }
function inserir($obj) {
    $sql = "INSERT INTO estado (nome, sigla) VALUES (?, ?)";
    $stmt = $this->con->prepare($sql);
    $nome = $obj->getNome();
		$sigla = $obj->getSigla();
		
    $stmt->execute([$nome, $sigla]);
}
}
?>