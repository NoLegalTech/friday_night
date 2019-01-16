<?php

    require_once(__DIR__.'/inc/functions.php');

    this_page_is_private();

    $usuario = user_get_logged_user();
    $emails  = user_get_emails();
    $tfnos   = user_get_tfnos();

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
        case 'delete_email':
            if (verifyFormToken('form_delete_email_' . $_POST['id_email'])) {
                verifyPostData(array(
                    'action', 'token', 'u',
                    'id_email'
                ));
                verifyUrl();
                if (db_delete('DELETE FROM email WHERE id = ' . $_POST['id_email'])) {
                    // all good
                    $emails = user_get_emails();
                } else {
                    doError('Se produjo un error inesperado al intentar borrar el email: <pre>' . $db->error . '</pre>');
                }
            } else {
                writeLog('form_delete_email_' . $_POST['id_email']);
                doError("Hack-Attempt detected. Got ya!.");
            }
            break;
        case 'delete_tfno':
            if (verifyFormToken('form_delete_tfno_' . $_POST['id_tfno'])) {
                verifyPostData(array(
                    'action', 'token', 'u',
                    'id_tfno'
                ));
                verifyUrl();
                if (db_delete('DELETE FROM telefono WHERE id = ' . $_POST['id_tfno'])) {
                    // all good
                    $tfnos = user_get_tfnos();
                } else {
                    doError('Se produjo un error inesperado al intentar borrar el teléfono: <pre>' . $db->error . '</pre>');
                }
            } else {
                writeLog('form_delete_tfno_' . $_POST['id_tfno']);
                doError("Hack-Attempt detected. Got ya!.");
            }
            break;
        case 'add_email':
            if (verifyFormToken('form_add_email')) {
                verifyPostData(array(
                    'action', 'token', 'u',
                    'email'
                ));
                verifyUrl();
                if (db_insert('INSERT INTO email(email, id_usuario) VALUES ("' . $_POST['email'] . '", ' . $usuario['id'] . ')')) {
                    // all good
                    $emails = user_get_emails();
                } else {
                    doError('Se produjo un error inesperado al intentar añadir el correo: <pre>' . $db->error . '</pre>');
                }
            } else {
                writeLog('form_add_email');
                doError("Hack-Attempt detected. Got ya!.");
            }
            break;
        case 'add_tfno':
            if (verifyFormToken('form_add_tfno')) {
                verifyPostData(array(
                    'action', 'token', 'u',
                    'telefono'
                ));
                verifyUrl();
                if (db_insert('INSERT INTO telefono(telefono, id_usuario) VALUES ("' . $_POST['telefono'] . '", ' . $usuario['id'] . ')')) {
                    // all good
                    $tfnos = user_get_tfnos();
                } else {
                    doError('Se produjo un error inesperado al intentar añadir el teléfono: <pre>' . $db->error . '</pre>');
                }
            } else {
                writeLog('form_add_tfno');
                doError("Hack-Attempt detected. Got ya!.");
            }
            break;
        case 'update_profile':
            if (verifyFormToken('form_perfil')) {
                verifyPostData(array(
                    'action', 'token', 'u',
                    'nombre', 'apellidos', 'dni', 'cp',
                    'oposicion_ideologia',
                    'oposicion_propaganda_fijo',
                    'oposicion_propaganda_movil',
                    'oposicion_propaganda_email'
                ));
                verifyUrl();
                if (db_update(
                    'UPDATE usuario SET '
                    . 'nombre     = "' . $_POST['nombre'] .'", '
                    . 'apellidos  = "' . $_POST['apellidos'] .'", '
                    . 'dni        = "' . $_POST['dni'] .'", '
                    . 'cp         = "' . $_POST['cp'] .'", '
                    . 'oposicion_ideologia        = "' . ( $_POST['oposicion_ideologia'] == 'on' ? 1 : 0 ) .'", '
                    . 'oposicion_propaganda_fijo  = "' . ( $_POST['oposicion_propaganda_fijo'] == 'on' ? 1 : 0 ) .'", '
                    . 'oposicion_propaganda_movil = "' . ( $_POST['oposicion_propaganda_movil'] == 'on' ? 1 : 0 ) .'", '
                    . 'oposicion_propaganda_email = "' . ( $_POST['oposicion_propaganda_email'] == 'on' ? 1 : 0 ) .'" '
                    . ' WHERE email = "' . $usuario['email'] . '"'
                ) === true) {
                    // all good
                    $usuario = user_update_logged_user();
                } else {
                    doError('Se produjo un error inesperado al intentar actualizar los datos: <pre>' . $db->error . '</pre>');
                }
            } else {
                writeLog('form_perfil');
                doError("Hack-Attempt detected. Got ya!.");
            }
            break;
        }

    }

    $token_perfil = generateFormToken('form_perfil');
    $token_add_email = generateFormToken('form_add_email');
    $token_add_tfno = generateFormToken('form_add_tfno');

    page_open();

?>

    <section class="posts">

        <article>
            <header>
                <h3>Tus datos</h3>
            </header>
            <hr/>

            <form id="form_perfil" method="post" action="perfil.php" class="alt">
                <input type="hidden" name="token" value="<?php echo $token_perfil; ?>">
                <input type="hidden" name="action" value="update_profile">
                <input type="hidden" name="u" value="">
                <div class="row uniform">
                    <div class="12u$ 12u$(xsmall)">
                        <input type="email" name="email" id="perfil_email" value="<?php echo $usuario['email']; ?>" placeholder="Email" disabled />
                    </div>
                    <div class="12u$ 12u$(xsmall)">
                        <input type="text" name="nombre" id="perfil_nombre" value="<?php echo $usuario['nombre']; ?>" placeholder="Nombre" />
                    </div>
                    <div class="12u$ 12u$(xsmall)">
                        <input type="text" name="apellidos" id="perfil_apellidos" value="<?php echo $usuario['apellidos']; ?>" placeholder="Apellidos" />
                    </div>
                    <div class="12u$ 12u$(small)">
                        <input type="text" name="dni" id="perfil_dni" value="<?php echo $usuario['dni']; ?>" placeholder="DNI" />
                    </div>
                    <div class="12u$ 12u$(small)">
                        <input type="text" name="cp" id="perfil_cp" value="<?php echo $usuario['cp']; ?>" placeholder="C.P." />
                    </div>
                    <div class="12u 12u$(small)">
                        <?php if ($usuario['oposicion_ideologia']) { ?>
                            <input type="checkbox" id="perfil_oposicion_ideologia" name="oposicion_ideologia" checked>
                        <?php } else { ?>
                            <input type="checkbox" id="perfil_oposicion_ideologia" name="oposicion_ideologia">
                        <?php } ?>
                        <label for="perfil_oposicion_ideologia">Manifiesto mi oposición a la recopilación de mis datos de ideología política en fuentes públicas (incluyendo páginas web y, en general, internet)</label>
                    </div>
                    <div class="12u 12u$(small)">
                        <?php if ($usuario['oposicion_propaganda_fijo']) { ?>
                            <input type="checkbox" id="perfil_oposicion_propaganda_fijo" name="oposicion_propaganda_fijo" checked>
                        <?php } else { ?>
                            <input type="checkbox" id="perfil_oposicion_propaganda_fijo" name="oposicion_propaganda_fijo">
                        <?php } ?>
                        <label for="perfil_oposicion_propaganda_fijo">Manifiesto mi oposición a la recepción de propaganda electoral en mi teléfono fijo</label>
                    </div>
                    <div class="12u 12u$(small)">
                        <?php if ($usuario['oposicion_propaganda_movil']) { ?>
                            <input type="checkbox" id="perfil_oposicion_propaganda_movil" name="oposicion_propaganda_movil" checked>
                        <?php } else { ?>
                            <input type="checkbox" id="perfil_oposicion_propaganda_movil" name="oposicion_propaganda_movil">
                        <?php } ?>
                        <label for="perfil_oposicion_propaganda_movil">Manifiesto mi oposición a la recepción de propaganda electoral en mi teléfono móvil</label>
                    </div>
                    <div class="12u 12u$(small)">
                        <?php if ($usuario['oposicion_propaganda_email']) { ?>
                            <input type="checkbox" id="perfil_oposicion_propaganda_email" name="oposicion_propaganda_email" checked>
                        <?php } else { ?>
                            <input type="checkbox" id="perfil_oposicion_propaganda_email" name="oposicion_propaganda_email">
                        <?php } ?>
                        <label for="perfil_oposicion_propaganda_email">Manifiesto mi oposición a la recepción de propaganda electoral en mi correo electrónico</label>
                    </div>
                    <div class="12u$">
                        <ul class="actions">
                            <li><input type="submit" value="Guardar" class="special" /></li>
                        </ul>
                    </div>
                </div>
            </form>
        </article>

        <article>
            <header>
                <h3>Direcciones de correo</h3>
            </header>
            <hr/>

            <div class="row">
                <div class="6u 12u$(small)">
                    <ul class="actions vertical">
                        <?php foreach($emails as $email) { ?>
                            <li style="text-align:left;"><?php echo $email['email']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="6u 12u$(small)">
                    <ul class="actions vertical small">
                        <?php foreach($emails as $email) {
                            $form_name = "form_delete_email_{$email['id']}";
                            $token_delete_email = generateFormToken($form_name);
                        ?>
                            <li>
                                <form id="<?php echo $form_name; ?>" method="post" action="perfil.php" class="alt">
                                    <input type="hidden" name="token" value="<?php echo $token_delete_email; ?>">
                                    <input type="hidden" name="action" value="delete_email">
                                    <input type="hidden" name="u" value="">
                                    <input type="hidden" name="id_email" value="<?php echo $email['id']; ?>">
                                    <input type="submit" value="Borrar" class="special" />
                                </form>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <form method="post" action="perfil.php" class="alt">
                <input type="hidden" name="action" value="add_email">
                <input type="hidden" name="token" value="<?php echo $token_add_email; ?>">
                <input type="hidden" name="u" value="">
                <div class="row uniform">
                    <div class="10u$ 12u$(xsmall)">
                        <input type="email" name="email" id="add-email" value="" placeholder="Email" />
                    </div>
                    <!-- Break -->
                    <div class="4u$ 12u$(xsmall)">
                        <ul class="actions">
                            <li><input type="submit" value="Añadir correo" class="special" /></li>
                        </ul>
                    </div>
                </div>
            </form>
            <hr/>

            <header>
                <h3>Teléfonos</h3>
            </header>
            <hr/>

            <div class="row">
                <div class="6u 12u$(small)">
                    <ul class="actions vertical">
                        <?php foreach($tfnos as $telefono) { ?>
                            <li style="text-align:left;"><?php echo $telefono['telefono']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="6u 12u$(small)">
                    <ul class="actions vertical small">
                        <?php foreach($tfnos as $telefono) {
                            $form_name = "form_delete_tfno_{$telefono['id']}";
                            $token_delete_tfno = generateFormToken($form_name);
                        ?>
                            <li>
                                <form id="<?php echo $form_name; ?>" method="post" action="perfil.php" class="alt">
                                    <input type="hidden" name="token" value="<?php echo $token_delete_tfno; ?>">
                                    <input type="hidden" name="action" value="delete_tfno">
                                    <input type="hidden" name="u" value="">
                                    <input type="hidden" name="id_tfno" value="<?php echo $telefono['id']; ?>">
                                    <input type="submit" value="Borrar" class="special" />
                                </form>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <form method="post" action="perfil.php" class="alt">
                <input type="hidden" name="action" value="add_tfno">
                <input type="hidden" name="token" value="<?php echo $token_add_tfno; ?>">
                <input type="hidden" name="u" value="">
                <div class="row uniform">
                    <div class="8u$ 12u$(xsmall)">
                        <input type="text" name="telefono" id="add-telefono" value="" placeholder="Teléfono" />
                    </div>
                    <!-- Break -->
                    <div class="4u$ 12u$(xsmall)">
                        <ul class="actions">
                            <li><input type="submit" value="Añadir teléfono" class="special" /></li>
                        </ul>
                    </div>
                </div>
            </form>
            <hr/>
        </article>

    </section>

<?php page_close(); ?>
