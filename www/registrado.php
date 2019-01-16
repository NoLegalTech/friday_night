<?php

    require_once(__DIR__.'/inc/functions.php');

    $token_activation = user_register();

    page_open();

?>

    <section class="post">
        <header>
            <h2>Bienvenido</h2>
        </header>

        <h4>Comprueba tu correo para activar tu cuenta</h4>
        <p>Comprueba tu bandeja de entrada en <?php echo $_POST['email']; ?>, donde te hemos enviado un correo con un enlace para activar tu cuenta.</p>

        <p style="color: red">
            Como esto es un prototipo y no manda emails aquí tienes el link:
        </p>

        <a style="color: red" href="<?php echo getPage('activation') . '?token=' . $token_activation; ?>">
            <?php echo getPage('activation') . '?token=' . $token_activation; ?>
        </a>
    </section>

<?php page_close(); ?>
