<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

class Creator {
    private $con;
    private $servidor;
    private $banco;
    private $usuario;
    private $senha;
    private $tabelas;

    function __construct() {
        if (isset($_GET['id'])) {
            $this->buscaBancodeDados();
        } else {
            $this->conectar(1);
            $this->criaDiretorios();
            $this->buscaTabelas();
            $this->ClassesModel();
            $this->ClasseConexao();
            $this->ClassesControl();
            $this->classesView();
            $this->criaEstilosCSS();
            $this->ClassesDao();
            $this->compactar();
            header("Location:index.php?msg=2");
        }
    }

    function criaDiretorios() {
        $dirs = [
            "sistema",
            "sistema/model",
            "sistema/control",
            "sistema/view",
            "sistema/dao",
            "sistema/css"
        ];

        foreach ($dirs as $dir) {
            if (!file_exists($dir)) {
                if (!mkdir($dir, 0777, true)) {
                    header("Location:index.php?msg=0");
                }
            }
        }
    }

    function conectar($id) {
        $this->servidor = $_POST["servidor"];
        $this->usuario = $_POST["usuario"];
        $this->senha = $_POST["senha"];
        if ($id == 1) {
            $this->banco = $_POST["banco"];
        } else {
            $this->banco = "mysql";
        }

        try {
            $this->con = new PDO(
                "mysql:host=" . $this->servidor . ";dbname=" . $this->banco,
                $this->usuario,
                $this->senha
            );
        } catch (Exception $e) {
            header("Location:index.php?msg=1");
        }
    }

    function buscaBancodeDados() {
        try {
            $this->conectar(0);
            $sql = "SHOW databases";
            $query = $this->con->query($sql);
            $databases = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($databases as $database) {
                echo "<option>" . $database["Database"] . "</option>";
            }
            $this->con = null;
        } catch (Exception $e) {
            header("Location:index.php?msg=3");
        }
    }

    function ClasseConexao() {
        $conteudo = <<<EOT
<?php
class Conexao {
    private \$server;
    private \$banco;
    private \$usuario;
    private \$senha;
    function __construct() {
        \$this->server = '{$this->servidor}';
        \$this->banco = '{$this->banco}';
        \$this->usuario = '{$this->usuario}';
        \$this->senha = '{$this->senha}';
    }
    function conectar() {
        try {
            \$conn = new PDO(
                "mysql:host=" . \$this->server . ";dbname=" . \$this->banco,
                \$this->usuario,
                \$this->senha
            );
            return \$conn;
        } catch (Exception \$e) {
            echo "Erro ao conectar com o Banco de dados: " . \$e->getMessage();
        }
    }
}
?>
EOT;
        file_put_contents("sistema/model/conexao.php", $conteudo);
    }

    function classesView() {
    if (empty($this->tabelas)) {
        header("Location:index.php?msg=4");
        exit;
    }
    foreach ($this->tabelas as $tabela) {
        $nomeTabela = reset($tabela);
        $atributos = $this->buscaAtributos($nomeTabela);

        $formCampos = "";
        $tabelaCabecalhos = "";
        $tabelaDados = "";
        foreach ($atributos as $atributo) {
            $campo = $atributo->Field;
            $tipo = $this->databaseParaInput($atributo->Type);

            if ($atributo->Key !== 'PRI' || !$atributo->isAutoIncrement) {
                $formCampos .= "        <label for='{$campo}'>" . ucfirst($campo) . "</label>\n";
                $formCampos .= "        <input type='{$tipo}' name='{$campo}' id='{$campo}'><br>\n";
            }

            $tabelaCabecalhos .= "            <th>" . ucfirst($campo) . "</th>\n";

            $tabelaDados .= "                <td>{{$campo}}</td>\n";
        }

        $conteudo = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Cadastro e Visualização de {$nomeTabela}</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="conteiner">
        <form method="POST" action="../control/{$nomeTabela}Control.php?a=1">
            <h2>Cadastro de {$nomeTabela}</h2>
{$formCampos}
            <input type="submit" value="Enviar">
        </form>

        <h2>Registros de {$nomeTabela}</h2>
        <table class="tabela-dados">
            <thead>
                <tr>
{$tabelaCabecalhos}
                </tr>
            </thead>
            <tbody>
                <tr>
{$tabelaDados}
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
HTML;
        file_put_contents("sistema/view/{$nomeTabela}.php", $conteudo);
    }
}

    function criaEstilosCSS() {
    $conteudo = <<<CSS
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.conteiner {
    max-width: 800px;
    margin: 0 auto;
}

form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

h2 {
    text-align: center;
    color: #333;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

input[type="text"], input[type="number"], input[type="date"], input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
}

input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus, input[type="email"]:focus {
    border-color: #007BFF;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

input[type="submit"] {
    background-color: #007BFF;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

input[type="submit"]:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.tabela-dados {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.tabela-dados th, .tabela-dados td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.tabela-dados th {
    background-color: #007BFF;
    color: white;
    font-weight: bold;
}

.tabela-dados tr:nth-child(even) {
    background-color: #f9f9f9;
}

.tabela-dados tr:hover {
    background-color: #f1f1f1;
}

.tabela-dados td {
    color: #333;
}
CSS;
    file_put_contents("sistema/css/estilos.css", $conteudo);
}

    function databaseParaInput($tipoBanco) {
        $tipoBase = preg_replace('/\(.*/', '', strtolower($tipoBanco));
        switch ($tipoBase) {
            case 'int':
            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'bigint':
            case 'decimal':
            case 'float':
            case 'double':
                return 'number';
            case 'varchar':
            case 'char':
            case 'text':
            case 'mediumtext':
            case 'longtext':
                return 'text';
            case 'date':
            case 'datetime':
            case 'timestamp':
                return 'date';
            case 'email':
                return 'email';
            default:
                return 'text';
        }
    }

    function ClassesModel() {
        if (!file_exists("sistema/model")) {
            mkdir("sistema/model", 0777, true);
        }
        $sql = "SHOW TABLES";
        $query = $this->con->query($sql);
        $tabelas = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tabelas as $tabela) {
            $nomeTabela = array_values((array) $tabela)[0];
            $atributos = $this->buscaAtributos($nomeTabela);
            $nomeAtributos = "";
            $geters_seters = "";
            foreach ($atributos as $atributo) {
                $field = $atributo->Field;
                $nomeAtributos .= "\tprivate \${$field};\n";
                $metodo = ucfirst($field);
                $geters_seters .= "\tfunction get{$metodo}(){\n";
                $geters_seters .= "\t\treturn \$this->{$field};\n\t}\n";
                $geters_seters .= "\tfunction set{$metodo}(\${$field}){\n";
                $geters_seters .= "\t\t\$this->{$field}=\${$field};\n\t}\n";
            }
            $nomeTabela = ucfirst($nomeTabela);

            $conteudo = <<<EOT
<?php
class {$nomeTabela} {
{$nomeAtributos}
{$geters_seters}
}
?>
EOT;
            file_put_contents("sistema/model/{$nomeTabela}.php", $conteudo);
        }
    }

    function buscaTabelas() {
        try {
            $sql = "SHOW TABLES";
            $query = $this->con->query($sql);
            $this->tabelas = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($this->tabelas)) {
                header("Location:index.php?msg=4");
            }
        } catch (Exception $e) {
            header("Location:index.php?msg=3");
        }
    }

    function buscaAtributos($nomeTabela) {
        $sql = "SHOW COLUMNS FROM " . $nomeTabela;
        $atributos = $this->con->query($sql)->fetchAll(PDO::FETCH_OBJ);
        foreach ($atributos as $atributo) {
            $atributo->isAutoIncrement = (stripos($atributo->Extra, 'auto_increment') !== false);
        }
        return $atributos;
    }

    function ClassesControl() {
        foreach ($this->tabelas as $tabela) {
            $nomeTabela = array_values((array)$tabela)[0];
            $atributos = $this->buscaAtributos($nomeTabela);
            $nomeClasse = ucfirst($nomeTabela);
            $posts = "";
            foreach ($atributos as $atributo) {
                if ($atributo->Key === 'PRI' && $atributo->isAutoIncrement) {
                    continue;
                }
                $field = $atributo->Field;
                $posts .= "\$this->{$nomeTabela}->set" . ucfirst($field) . "(\$_POST['{$field}']);\n\t\t";
            }

            $conteudo = <<<EOT
<?php
require_once("../model/{$nomeClasse}.php");
require_once("../dao/{$nomeClasse}Dao.php");
class {$nomeClasse}Control {
    private \$model;
    private \$acao;
    private \$dao;
    public function __construct(){
       \$this->model = new {$nomeClasse}();
      \$this->dao = new {$nomeClasse}Dao();
      \$this->acao = \$_GET["a"];
      \$this->verificaAcao(); 
    }
    function verificaAcao(){
       switch(\$this->acao){
          case 1:
            \$this->inserir();
          break;
       }
    }
    function inserir(){
        {$posts}
        \$this->dao->inserir(\$this->model);
    }
    function excluir(){}
    function alterar(){}
    function buscarId({$nomeClasse} \${$nomeTabela}){}
    function buscaTodos(){}

}
new {$nomeClasse}Control();
?>
EOT;
            file_put_contents("sistema/control/{$nomeTabela}Control.php", $conteudo);
        }
    }

    function compactar() {
        $folderToZip = 'sistema';
        $outputZip = 'sistema.zip';
        $zip = new ZipArchive();
        if ($zip->open($outputZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            return false;
        }
        $folderPath = realpath($folderToZip);
        if (!is_dir($folderPath)) {
            return false;
        }
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folderPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($folderPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        return $zip->close();
    }

    function ClassesDao() {
        foreach ($this->tabelas as $tabela) {
            $nomeTabela = array_values((array)$tabela)[0];
            $nomeClasse = ucfirst($nomeTabela);
            $atributos = $this->buscaAtributos($nomeTabela);
            $sqlCols = [];
            $placeholders = [];
            $vetAtributos = [];
            $AtributosMetodos = "";
            $priField = null;
            foreach ($atributos as $atributo) {
                $field = $atributo->Field;
                $atr = ucfirst($field);
                if ($atributo->Key === 'PRI' && $atributo->isAutoIncrement) {
                    $priField = $field;
                    continue;
                }
                $sqlCols[] = $field;
                $placeholders[] = '?';
                $vetAtributos[] = "\${$field}";
                $AtributosMetodos .= "\${$field} = \$obj->get{$atr}();\n\t\t";
            }
            $sqlColsStr = implode(', ', $sqlCols);
            $placeholdersStr = implode(', ', $placeholders);
            $atributosOk = implode(', ', $vetAtributos);

            $conteudo = <<<EOT
<?php
require_once("../model/conexao.php");
class {$nomeClasse}Dao {
    private \$con;
    public function __construct(){
       \$this->con=(new Conexao())->conectar();
    }
function inserir(\$obj) {
    \$sql = "INSERT INTO {$nomeTabela} ({$sqlColsStr}) VALUES ({$placeholdersStr})";
    \$stmt = \$this->con->prepare(\$sql);
    {$AtributosMetodos}
    \$stmt->execute([{$atributosOk}]);
}
}
?>
EOT;
            file_put_contents("sistema/dao/{$nomeClasse}Dao.php", $conteudo);
        }
    }
}

new Creator();
