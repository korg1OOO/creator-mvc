<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de pizza</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <form method="POST" action="../control/pizzaControl.php?a=1">
        <h2>Cadastro de pizza</h2>
        <label for='qtdSabores'>qtdSabores</label>
        <input type='number' name='qtdSabores' id='qtdSabores'><br>
        <label for='sabor1'>sabor1</label>
        <input type='text' name='sabor1' id='sabor1'><br>
        <label for='sabor2'>sabor2</label>
        <input type='text' name='sabor2' id='sabor2'><br>
        <label for='tamanho'>tamanho</label>
        <input type='text' name='tamanho' id='tamanho'><br>
        <label for='borda'>borda</label>
        <input type='text' name='borda' id='borda'><br>
        <label for='preco'>preco</label>
        <input type='number' name='preco' id='preco'><br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>