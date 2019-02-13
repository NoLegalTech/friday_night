<?php

    require_once(__DIR__.'/inc/functions.php');

    $token_registro = generateFormToken('form_registro');
    $token_login = generateFormToken('form_login');

    page_open();

?>

    <section class="posts">
        <article>
            <header class="major">
                <h2>Registro</h2>
            </header>

                <form id="form_registro" method="post" action="registrado_partido.php" class="alt">
                    <input type="hidden" name="token" value="<?php echo $token_registro; ?>">
                    <input type="hidden" name="u" value="">
                    <div class="row uniform">
                        <div class="12u$ 12u$(xsmall)">
                            <input type="email" name="email" id="registro_email" value="" placeholder="Email" />
                        </div>
                        <div class="12u$ 12u$(xsmall)">
                            <input type="password" name="pass" id="registro_pass" value="" placeholder="Contraseña" />
                        </div>
                        <!-- Break -->
                        <div class="12u$">
                            <ul class="actions">
                                <li><input type="submit" value="Registrar" class="special" /></li>
                            </ul>
                        </div>
                    </div>
                </form>

                <hr />
        </article>

        <article>
            <header class="major">
                <h2>Acceso</h2>
            </header>

                <form id="form_login" method="post" action="login_partido.php" class="alt">
                    <input type="hidden" name="token" value="<?php echo $token_login; ?>">
                    <input type="hidden" name="u" value="">
                    <div class="row uniform">
                        <div class="12u$ 12u$(xsmall)">
                            <input type="email" name="email" id="login_email" value="" placeholder="Email" />
                        </div>
                        <div class="12u$ 12u$(xsmall)">
                            <input type="password" name="pass" id="login_pass" value="" placeholder="Contraseña" />
                        </div>
                        <!-- Break -->
                        <div class="12u$">
                            <ul class="actions">
                                <li><input type="submit" value="Entrar" class="special" /></li>
                            </ul>
                        </div>
                    </div>
                </form>

                <hr />
        </article>
    </section>

<?php page_close(); ?>
