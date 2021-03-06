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

    <article class="post featured">
        <dl>
            <dt>¿Por qué hace falta una “Lista Viernes”?</dt>
            <dd>
                <p>El pasado 6 de diciembre de 2018 se cambió la ley electoral y ahora permite que los partidos políticos traten tus datos de formas antes no permitidas para enviarte propaganda electoral. Por ejemplo, ahora pueden utilizar tus comentarios en redes sociales para saber qué piensas, hacer perfiles y enviarte mensajes a tu email o teléfono con consignas personalizadas para ti.</p>
                <p>Para evitarlo puedes esperar a que te empiecen a llegar mensajes y utilizar el link para oponerte a recibir más… confiando en que te hagan caso.</p>
                <p>También puedes utilizar este formulario, rellenarlo y enviarlo uno a uno a todos los partidos que se presenten en tu circunscripción.</p>
                <p>Y puedes apuntarte a la Lista Viernes. Si nos apuntamos mucha, pero mucha gente, te librarás de la propaganda de todos los partidos de un solo golpe.</p>
            </dd>
            <dt>¿Quién puede inscribirse en la Lista Viernes?</dt>
            <dd>
                <p>Todos los ciudadanos con derecho de voto.</p>
            </dd>
            <dt>¿Para qué te servirá a ti, ciudadano?</dt>
            <dd>
                <p>Inscribiéndote en la Lista Viernes, podrás:</p>
                <p>Hacer valer tu oposición a que te envíen propaganda electoral a las direcciones de correo electrónico y teléfonos de contacto que nos proporciones.</p>
                <p>Sólo tienes que inscribirte una sola vez, para librarte de la propaganda de todos los partidos que concurran a tu circunscripción electoral.</p>
                <p>Hacer valer tu oposición a que tus datos de ideología (o cualesquiera otros) que hayas “hecho manifiestamente públicos” porque te ha dado la gana, en páginas web y redes sociales, sean “recopilados” y utilizados para otros fines distintos, en este caso para fines electorales de los partidos políticos.</p>
            </dd>
        </dl>
    </article>

    <section class="posts">
        <article>
            <header class="major">
                <h2>Empieza aquí</h2>
                <p>Serán 5 minutos.</p>
            </header>

                <p>
                    Inserta tu dirección de email (preferiblemente una que tengas expuesta en internet (tu empresa) o redes sociales (linkedin, twitter, instagram ¿?)
                </p>

                <form id="form_registro" method="post" action="registrado.php" class="alt">
                    <input type="hidden" name="token" value="<?php echo $token_registro; ?>">
                    <input type="hidden" name="u" value="">
                    <input type="hidden" name="hash_email" value="">
                    <div class="row uniform">
                        <div class="12u$ 12u$(xsmall)">
                            <input type="email" name="email" id="registro_email" value="" placeholder="Email" />
                        </div>
                        <div class="12u$ 12u$(xsmall)">
                            <input type="password" name="pass" id="registro_pass" value="" placeholder="Contraseña" />
                        </div>
                        <!-- Break -->
                        <div class="12u 12u$(small)">
                            <input type="checkbox" id="confirm-vote" name="confirm-vote">
                            <label for="confirm-vote">Confirmo que tengo derecho a voto en las elecciones de mayo de 2019</label>
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
                <h2>¿Ya te has dado de alta?</h2>
                <p>Identifícate aquí</p>
            </header>

                <form id="form_login" method="post" action="login.php" class="alt">
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
