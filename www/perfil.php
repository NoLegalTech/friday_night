<?php

    /*
     * Lista Viernes, a tool to create a secured data base of citizens to publicly
     * state rejection to use their data for political campaigns.
     *
     * Copyright (C) 2019  NoLegalTech
     *
     *    This program is free software; you can redistribute it and/or modify
     *    it under the terms of the GNU General Public License as published by
     *    the Free Software Foundation; either version 3 of the License, or
     *    (at your option) any later version.
     *
     *    This program is distributed in the hope that it will be useful,
     *    but WITHOUT ANY WARRANTY; without even the implied warranty of
     *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *    GNU General Public License for more detai
     *
     *    You should have received a copy of the GNU General Public License
     *    along with this program; if not, write to the Free Software Foundation,
     *    Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301
     *
     */

    require_once(__DIR__.'/inc/functions.php');

    this_page_is_private_for('user');

    $usuario = user_get_logged_user();
    $emails  = user_get_emails();
    $tfnos   = user_get_tfnos();

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
        case 'delete_email':
            $emails = perfil_delete_email();
            break;
        case 'delete_tfno':
            $tfnos = perfil_delete_tfno();
            break;
        case 'add_email':
            $emails = perfil_add_email();
            break;
        case 'add_tfno':
            $tfnos = perfil_add_tfno();
            break;
        case 'update_profile':
            $usuario = perfil_update();
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
            <form id="form_add_email" method="post" action="perfil.php" class="alt">
                <input type="hidden" name="action" value="add_email">
                <input type="hidden" name="token" value="<?php echo $token_add_email; ?>">
                <input type="hidden" name="u" value="">
                <input type="hidden" name="hash_email" value="">
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
            <form id="form_add_tfno" method="post" action="perfil.php" class="alt">
                <input type="hidden" name="action" value="add_tfno">
                <input type="hidden" name="token" value="<?php echo $token_add_tfno; ?>">
                <input type="hidden" name="u" value="">
                <input type="hidden" name="hash_tfno" value="">
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
