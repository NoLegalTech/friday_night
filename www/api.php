<?php

    require_once(__DIR__.'/inc/functions.php');

    this_page_is_private_for('party');

    $token_api = generateFormToken('form_api');

    page_open();

?>

    <section class="post">

        <article class="to_hide">

            <header>
                <h3>API</h3>
            </header>
            <hr/>

            <p>
                Introduce a continuación tu lista de emails y/o teléfonos separados por comas<br/>(ejemplo: <em>usuario@listaviernes.es,600123456,otro@email.com,666333111</em>):
            </p>
            <form id="form_api" method="post" action="api/check.php" class="alt">
                <input type="hidden" name="token" value="<?php echo $token_api; ?>">
                <input type="hidden" name="u" value="">
                <input type="hidden" name="hash_data" value="">
                <div class="row uniform">
                    <div class="12u$ 12u$(xsmall)">
                        <textarea name="data"></textarea>
                    </div>
                    <!-- Break -->
                    <div class="12u$">
                        <ul class="actions">
                            <li><input type="submit" value="Verificar" class="special" /></li>
                        </ul>
                    </div>
                </div>
            </form>

        </article>

        <article class="to_show" style="display: none">

            <header>
                <h3>Resultado de la consulta</h3>
            </header>
            <hr/>

            <p>
                Puedes enviar tus comunicaciones a estos:
                <textarea id="accepted"></textarea>
            </p>

            <p>
                Deberías borrar de tu base de datos:
                <textarea id="rejected"></textarea>
            </p>

            <div class="12u$">
                <form method="get" action="api.php" class="alt">
                    <ul class="actions">
                        <li><input type="submit" value="Otra consulta" class="special" /></li>
                    </ul>
                </form>
            </div>
        </article>

    </section>

<?php page_close(); ?>
