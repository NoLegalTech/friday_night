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

    $token_registro = generateFormToken('form_registro');
    $token_login = generateFormToken('form_login');

    page_open();

?>

    <section class="posts">
        <article>
            <header class="major">
                <h2>Acceso administración</h2>
            </header>

                <form id="form_login" method="post" action="login_admin.php" class="alt">
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
