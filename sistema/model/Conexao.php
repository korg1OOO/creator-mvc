    <?php
        class Conexao {
            	private $id;
	private $servidor;
	private $banco;
	private $usuario;
	private $senha;

            	function getId(){
		return $this->id;
	}
	function setId($id){
		$this->id=$id;
	}
	function getServidor(){
		return $this->servidor;
	}
	function setServidor($servidor){
		$this->servidor=$servidor;
	}
	function getBanco(){
		return $this->banco;
	}
	function setBanco($banco){
		$this->banco=$banco;
	}
	function getUsuario(){
		return $this->usuario;
	}
	function setUsuario($usuario){
		$this->usuario=$usuario;
	}
	function getSenha(){
		return $this->senha;
	}
	function setSenha($senha){
		$this->senha=$senha;
	}

        }
    ?>