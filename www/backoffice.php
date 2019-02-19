<?php

    require_once(__DIR__.'/inc/functions.php');

    this_page_is_private_for('admin');

    page_open();

?>

    <section class="posts">

        <article>
            <header>
                <h3>Backoffice</h3>
            </header>
            <hr/>

            <p>
            Usuarios registrados: <strong><?php echo admin_get_num_users(); ?></strong>
            </p>

        </article>

    </section>

<?php page_close(); ?>
