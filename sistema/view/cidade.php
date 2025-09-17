<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de cidade</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <form method="POST" action="../control/cidadeControl.php?a=1">
        <h2>Cadastro de cidade</h2>
        <label for='nome'>nome</label>
        <input type='text' name='nome' id='nome'><br>
        <label for='habitantes'>habitantes</label>
        <input type='number' name='habitantes' id='habitantes'><br>
        <label for='idestado'>idestado</label>
        <input type='number' name='idestado' id='idestado'><br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>