    <!DOCTYPE html>
    <html>
    <head>
        <title>Cadastro de livros</title>
        <link rel="stylesheet" href="../css/estilos.css">
    </head>
    <body>
        <form method="POST" action="../control/livrosControl.php?a=1">
            <h2>Cadastro de livros</h2>
            <label for='campo_titulo'>titulo</label>
        <input type='text' name='campo_titulo' id='campo_titulo'><br>
        <label for='campo_genero'>genero</label>
        <input type='text' name='campo_genero' id='campo_genero'><br>
        <label for='campo_qtd_paginas'>qtd_paginas</label>
        <input type='number' name='campo_qtd_paginas' id='campo_qtd_paginas'><br>
        <label for='campo_autor'>autor</label>
        <input type='text' name='campo_autor' id='campo_autor'><br>

            <input type="submit" value="Enviar">
        </form>
    </body>
    </html>