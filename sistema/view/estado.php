<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de estado</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <form method="POST" action="../control/estadoControl.php?a=1">
        <h2>Cadastro de estado</h2>
        <label for='nome'>nome</label>
        <input type='text' name='nome' id='nome'><br>
        <label for='sigla'>sigla</label>
        <input type='text' name='sigla' id='sigla'><br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>