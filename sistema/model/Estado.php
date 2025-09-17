<?php
class Estado {
	private $id;
	private $nome;
	private $sigla;

	function getId(){
		return $this->id;
	}
	function setId($id){
		$this->id=$id;
	}
	function getNome(){
		return $this->nome;
	}
	function setNome($nome){
		$this->nome=$nome;
	}
	function getSigla(){
		return $this->sigla;
	}
	function setSigla($sigla){
		$this->sigla=$sigla;
	}

}
?>