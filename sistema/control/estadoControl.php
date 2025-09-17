<?php
require_once("../model/Estado.php");
require_once("../dao/EstadoDao.php");
class EstadoControl {
    private $estado;
    private $acao;
    private $dao;
    public function __construct(){
       $this->estado=new Estado();
      $this->dao=new EstadoDao();
      $this->acao=$_GET["a"];
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
        $this->estado->setNome($_POST['nome']);
		$this->estado->setSigla($_POST['sigla']);
		
        $this->dao->inserir($this->estado);
    }
    function excluir(){}
    function alterar(){}
    function buscarId(Estado $estado){}
    function buscaTodos(){}

}
new EstadoControl();
?>