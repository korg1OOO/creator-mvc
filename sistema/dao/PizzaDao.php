<?php
require_once("../model/conexao.php");
class PizzaDao {
    private $con;
    public function __construct(){
       $this->con=(new Conexao())->conectar();
    }
function inserir($obj) {
    $sql = "INSERT INTO pizza (qtdSabores, sabor1, sabor2, tamanho, borda, preco) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->con->prepare($sql);
    $qtdSabores = $obj->getQtdSabores();
		$sabor1 = $obj->getSabor1();
		$sabor2 = $obj->getSabor2();
		$tamanho = $obj->getTamanho();
		$borda = $obj->getBorda();
		$preco = $obj->getPreco();
		
    $stmt->execute([$qtdSabores, $sabor1, $sabor2, $tamanho, $borda, $preco]);
}
}
?>