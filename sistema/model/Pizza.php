<?php
class Pizza {
	private $id;
	private $qtdSabores;
	private $sabor1;
	private $sabor2;
	private $tamanho;
	private $borda;
	private $preco;

	function getId(){
		return $this->id;
	}
	function setId($id){
		$this->id=$id;
	}
	function getQtdSabores(){
		return $this->qtdSabores;
	}
	function setQtdSabores($qtdSabores){
		$this->qtdSabores=$qtdSabores;
	}
	function getSabor1(){
		return $this->sabor1;
	}
	function setSabor1($sabor1){
		$this->sabor1=$sabor1;
	}
	function getSabor2(){
		return $this->sabor2;
	}
	function setSabor2($sabor2){
		$this->sabor2=$sabor2;
	}
	function getTamanho(){
		return $this->tamanho;
	}
	function setTamanho($tamanho){
		$this->tamanho=$tamanho;
	}
	function getBorda(){
		return $this->borda;
	}
	function setBorda($borda){
		$this->borda=$borda;
	}
	function getPreco(){
		return $this->preco;
	}
	function setPreco($preco){
		$this->preco=$preco;
	}

}
?>