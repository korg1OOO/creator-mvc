<?php
require_once("../model/conexao.php");
class CidadeDao {
    private $con;
    public function __construct(){
       $this->con=(new Conexao())->conectar();
    }
function inserir($obj) {
    $sql = "INSERT INTO cidade (nome, habitantes, idestado) VALUES (?, ?, ?)";
    $stmt = $this->con->prepare($sql);
    $nome = $obj->getNome();
		$habitantes = $obj->getHabitantes();
		$idestado = $obj->getIdestado();
		
    $stmt->execute([$nome, $habitantes, $idestado]);
}
}
?>