<?php
require_once("../model/Pizza.php");
require_once("../dao/PizzaDao.php");
class PizzaControl {
    private $model;
    private $acao;
    private $dao;
    public function __construct(){
       $this->model = new Pizza();
      $this->dao = new PizzaDao();
      $this->acao = $_GET["a"];
      $this->verificaAcao(); 
    }
    function verificaAcao(){
       switch($this->acao){
          case 1:
            $this->inserir();
          break;
       }
    }
    function inserir(){
        $this->pizza->setQtdSabores($_POST['qtdSabores']);
		$this->pizza->setSabor1($_POST['sabor1']);
		$this->pizza->setSabor2($_POST['sabor2']);
		$this->pizza->setTamanho($_POST['tamanho']);
		$this->pizza->setBorda($_POST['borda']);
		$this->pizza->setPreco($_POST['preco']);
		
        $this->dao->inserir($this->model);
    }
    function excluir(){}
    function alterar(){}
    function buscarId(Pizza $pizza){}
    function buscaTodos(){}

}
new PizzaControl();
?>