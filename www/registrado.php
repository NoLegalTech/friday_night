<?php

    require_once(__DIR__.'/inc/functions.php');

    if (verifyFormToken('form_registro')) {
        verifyPostData(array('token', 'email', 'pass', 'confirm-vote', 'u'));
        verifyEmail();
        verifyUrl();
        $rows = db_query('SELECT * FROM usuario WHERE email = "' . $_POST['email'] . '"');
        if (count($rows) > 0) {
            doError('El email introducido corresponde a un usuario ya registrado y por tanto no se puede registrar de nuevo.');
        }
        $token_activation = getRandomToken();
        if (db_insert('INSERT INTO usuario(email, password, activation_token) VALUES ("' . $_POST['email'] . '", "' . $_POST['pass'] . '", "' . $token_activation . '")') === true) {
            // send email
        } else {
            doError('Se produjo un error inesperado al intentar registrar el usuario: <pre>' . $db->error . '</pre>');
        }
    } else {
        writeLog('form_registro');
        doError("Hack-Attempt detected. Got ya!.");
    }

    page_open();

?>

                        <!-- Post -->
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

                    </div>

<?php page_close(); ?>
