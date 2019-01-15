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
    unset($_SESSION['error']);

    db_close();
?>
