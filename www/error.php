<?php

    require_once(__DIR__.'/inc/functions.php');

    page_open();

?>

                        <!-- Post -->
                            <section class="post">
                                <header>
                                    <h2>Error</h2>
                                </header>


                                <p>
                                    <?php
                                        if (isset($_SESSION['error'])) {
                                            echo $_SESSION['error'];
                                        } else {
                                            echo 'Error inesperado.';
                                        }
                                    ?>
                                </p>

                            </section>

                    </div>

<?php
    unset($_SESSION['error']);

    page_close();
?>
