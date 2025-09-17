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
    <?php
        include "mensagens.php";
        if (isset($_GET["msg"])) {
            $msg = $_GET["msg"];
            $classe = $msg == 2 ? "mensagem" : "mensagem_erro";
            echo "<div class=\"$classe\">" . ($mensagens[$msg] ?? "Erro desconhecido") . "</div>";
        }

        $bancos = [];
        $erro = null;
        $servidor = isset($_POST['servidor']) ? $_POST['servidor'] : '';
        $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
        $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['servidor']) && isset($_POST['usuario'])) {
            try {
                $con = new PDO("mysql:host=$servidor", $usuario, $senha);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $result = $con->query("SHOW DATABASES");
                $bancos = $result->fetchAll(PDO::FETCH_COLUMN);
                if (empty($bancos)) {
                    $erro = "Nenhum banco de dados encontrado para o usuário fornecido. Verifique as permissões.";
                }
            } catch (PDOException $e) {
                $erro = "Erro ao conectar ao MySQL: " . htmlspecialchars($e->getMessage());
            }
        }
    ?>

    <?php if ($erro): ?>
        <div class="mensagem_erro"><?php echo $erro; ?></div>
    <?php endif; ?>

    <?php if (empty($bancos)): ?>
        <form method="POST" action="index.php" id="connection-form" class="connection-form" autocomplete="off" role="main">
            <h1 class="a11y-hidden">GERADOR DE MVC</h1>
            <h2>GERADOR DE MVC</h2>
            <h3>Faça seu Login!</h3>
            <div>
                <label class="label-servidor">
                    <input type="text" class="text" name="servidor" placeholder="Servidor" tabindex="1" required value="<?php echo htmlspecialchars($servidor); ?>" />
                    <span class="required">Servidor</span>
                </label>
            </div>
            <div>
                <label class="label-usuario">
                    <input type="text" class="text" name="usuario" placeholder="Usuário" tabindex="2" required value="<?php echo htmlspecialchars($usuario); ?>" />
                    <span class="required">Usuário</span>
                </label>
            </div>
            <div>
    <label class="label-senha">
        <input type="password" class="text" name="senha" placeholder="Senha" tabindex="3" value="<?php echo htmlspecialchars($senha); ?>" />
        <span>Senha</span>
    </label>
</div>
            <input type="submit" value="Carregar Bancos de Dados" />
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
    <?php else: ?>
        <form method="POST" action="creator.php" id="selection-form" class="connection-form" autocomplete="off" role="main">
            <div>
                <label class="label-banco">
                    <select class="text" name="banco" tabindex="1" required>
                        <option value="" disabled selected>Selecione um Banco de Dados</option>
                        <?php foreach ($bancos as $banco): ?>
                            <option value="<?php echo $banco; ?>" <?php echo (isset($_POST['banco']) && $_POST['banco'] === $banco) ? 'selected' : ''; ?>>
                                <?php echo $banco; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="required">Banco de Dados</span>
                </label>
            </div>
            <input type="hidden" name="servidor" value="<?php echo $servidor; ?>">
            <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
            <input type="hidden" name="senha" value="<?php echo $senha; ?>">
            <input type="submit" value="Confirmar" />
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
    <?php endif; ?>
</body>
</html>