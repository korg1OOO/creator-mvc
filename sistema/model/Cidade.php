<?php
class Cidade {
	private $id;
	private $nome;
	private $habitantes;
	private $idestado;

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
	function getHabitantes(){
		return $this->habitantes;
	}
	function setHabitantes($habitantes){
		$this->habitantes=$habitantes;
	}
	function getIdestado(){
		return $this->idestado;
	}
	function setIdestado($idestado){
		$this->idestado=$idestado;
	}

}
?>