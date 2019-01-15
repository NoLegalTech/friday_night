<?php

    require_once(__DIR__.'/inc/functions.php');

    $rows = db_query('SELECT * FROM usuario WHERE activation_token = "' . $_GET['token'] . '"');
    if (count($rows) != 1) {
        doError('Token no válido.');
    }
    if (db_update('UPDATE usuario SET activation_token = NULL WHERE activation_token = "' . $_GET['token'] . '"') === true) {
        // nothing?
    } else {
        doError('Token no válido.');
    }

    page_open();

?>

                        <!-- Post -->
                            <section class="post">
                                <header>
                                    <h2>Bienvenido</h2>
                                </header>


                                <p>Tu cuenta ha sido activada con éxito. Vuelve a la página principal para identificarte.</p>

                            </section>

                    </div>

<?php page_close(); ?>
