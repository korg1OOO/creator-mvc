<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Conexão</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- AVISO: PEGUEI ESTILIZAÇÃO DO TEMPLATE https://codepen.io/alvaromontoro/pen/JjoWVmx -->
    <form method="POST" action="creator.php" id="connection-form" class="connection-form" autocomplete="off" role="main">
        <?php

            include "erros.php";
            if (isset($_GET["msg"])) {
                echo "<div id='mensagem'>" . ($mensagens[$msg] ?? "Erro desconhecido");
            }
        ?>
    <h1 class="a11y-hidden">Formulário de Conexão</h1>
        <h2>Gerenciador de Conexão</h2>
        <h3>Faça seu Login!</h3>

        <div>
            <label class="label-servidor">
                <input type="text" class="text" name="servidor" placeholder="Servidor" tabindex="1" required />
                <span class="required">Servidor</span>
            </label>
        </div>
        <div>
            <label class="label-banco">
                <input type="text" class="text" name="banco" placeholder="Banco de Dados" tabindex="2" required />
                <span class="required">Banco de Dados</span>
            </label>
        </div>
        <div>
            <label class="label-usuario">
                <input type="text" class="text" name="usuario" placeholder="Usuário" tabindex="3" required />
                <span class="required">Usuário</span>
            </label>
        </div>
        <div>
            <label class="label-senha">
                <input type="text" class="text" name="senha" placeholder="Senha" tabindex="4" />
                <span>Senha</span>
            </label>
        </div>

        <input type="submit" value="Enviar" />
        <figure aria-hidden="true">
            <div class="person-body"></div>
            <div class="neck skin"></div>
            <div class="head skin">
                <div class="eyes"></div>
                <div class="mouth"></div>
            </div>
            <div class="hair"></div>
            <div class="ears"></div>
            <div class="shirt-1"></div>
            <div class="shirt-2"></div>
        </figure>
    </form>
</body>
</html>