<?php

    require_once(__DIR__.'/inc/functions.php');

    $db = db_connect();
    $rows = db_query($db, 'SELECT * FROM usuario WHERE activation_token = "' . $_GET['token'] . '"');
    if (count($rows) != 1) {
        doError('Token no válido.');
    }
    if (db_update($db, 'UPDATE usuario SET activation_token = NULL WHERE activation_token = "' . $_GET['token'] . '"') === true) {
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

                <!-- Footer -->
                    <footer id="footer">
                    </footer>

                <!-- Copyright -->
                    <div id="copyright">
                        <ul>
                            <li>&copy; <a target="_blank" href="https://secuoyagroup.com/">Secuoya Group</a></li>
                            <li>Design: <a target="_blank" href="https://html5up.net">HTML5 UP</a></li>
                            <li>Distributor: <a target="_blank" href="https://themewagon.com">ThemeWagon</a></li>
                        </ul>
                    </div>

            </div>

        <!-- Scripts -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/jquery.scrollex.min.js"></script>
            <script src="assets/js/jquery.scrolly.min.js"></script>
            <script src="assets/js/skel.min.js"></script>
            <script src="assets/js/util.js"></script>
            <script src="assets/js/crypto-js.js"></script>
            <script src="assets/js/main.js"></script>

    </body>
</html>

<?php
    db_close();
?>
