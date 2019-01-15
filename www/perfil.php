<?php

    session_start();

    require_once(__DIR__.'/inc/functions.php');

    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
    } else {
        if (verifyFormToken('form_login')) {
            verifyPostData(array('token', 'email', 'pass', 'u'));
            verifyEmail();
            verifyUrl();
            $db = db_connect();
            $rows = db_query($db, 'SELECT * FROM usuario WHERE email = "' . $_POST['email'] . '" AND password = "' . $_POST['pass'] . '" AND activation_token IS NULL');
            if (count($rows) != 1) {
                doError('Login incorrecto.');
            }
            $usuario = $rows[0];
            $_SESSION['usuario'] = $usuario;
        } else {
            writeLog('form_login');
            doError("Hack-Attempt detected. Got ya!.");
        }
    }

?>

<!DOCTYPE HTML>
<!--
    Massively by HTML5 UP
    html5up.net | @ajlkn
    Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
    <head>
        <title>Lista Viernes</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    </head>
    <body class="is-loading">

        <!-- Wrapper -->
            <div id="wrapper">

                <!-- Header -->
                    <header id="header">
                        <a href="index.php" class="logo">Lista viernes</a>
                    </header>

                <!-- Nav -->
                    <nav id="nav">
                        <ul class="links">
                            <li><a href="index.php">Lista Viernes</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="presentacion.html">Presentación</a></li>
                            <li><a href="perfil.php">Mi perfil</a></li>
                            <li class="logout"><a href="index.php">Cerrar sesión</a></li>
                        </ul>
                        <ul class="icons">
                            <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                            <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                            <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
                            <li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>
                        </ul>
                    </nav>

                <!-- Main -->
                    <div id="main">

                        <!-- Post -->
                            <section class="post">
                                <header>
                                    <h2>Bienvenido</h2>
                                    <h3>Tus datos</h3>
                                </header>
                                <hr/>

                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <b>ID:</b>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <?php echo $usuario['id']; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <b>Email:</b>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <?php echo $usuario['email']; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <b>Nombre:</b>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <?php echo $usuario['nombre']; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <b>Apellidos:</b>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <?php echo $usuario['apellidos']; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <b>DNI:</b>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <?php echo $usuario['dni']; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <b>Código Postal:</b>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <?php echo $usuario['cp']; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <b>Manifiesto mi oposición a la recopilación de mis datos de ideología política en fuentes públicas (incluyendo páginas web y, en general, internet):</b>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <?php echo $usuario['oposicion_ideologia']; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <b>Manifiesto mi oposición a la recepción de propaganda electoral en mi teléfono fijo:</b>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <?php echo $usuario['oposicion_propaganda_fijo']; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <b>Manifiesto mi oposición a la recepción de propaganda electoral en mi teléfono móvil:</b>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <?php echo $usuario['oposicion_propaganda_movil']; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <b>Manifiesto mi oposición a la recepción de propaganda electoral en mi correo electrónico:</b>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <?php echo $usuario['oposicion_propaganda_email']; ?>
                                    </div>
                                </div>


                                <h4>Direcciones de correo</h4>
                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <ul class="actions vertical">
                                            <li>p******u@gmail.com</li>
                                        </ul>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <ul class="actions vertical small">
                                            <li><a href="#" class="button special small">Borrar</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <form method="post" action="identificado.html" class="alt">
                                    <div class="row uniform">
                                        <div class="6u$ 12u$(xsmall)">
                                            <input type="email" name="demo-email" id="demo-email" value="" placeholder="Email" />
                                        </div>
                                        <!-- Break -->
                                        <div class="12u$">
                                            <ul class="actions">
                                                <li><input type="submit" value="Añadir correo" class="special" /></li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                                <hr/>

                                <h4>Teléfonos</h4>
                                <div class="row">
                                    <div class="4u 12u$(small)">
                                        <ul class="actions vertical">
                                            <li>65******6</li>
                                            <li>88******7</li>
                                        </ul>
                                    </div>
                                    <div class="6u 12u$(small)">
                                        <ul class="actions vertical small">
                                            <li><a href="#" class="button special small">Borrar</a></li>
                                            <li><a href="#" class="button special small">Borrar</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <form method="post" action="identificado.html" class="alt">
                                    <div class="row uniform">
                                        <div class="6u$ 12u$(xsmall)">
                                            <input type="text" name="demo-phone" id="demo-phone" value="" placeholder="Teléfono" />
                                        </div>
                                        <!-- Break -->
                                        <div class="12u$">
                                            <ul class="actions">
                                                <li><input type="submit" value="Añadir teléfono" class="special" /></li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                                <hr/>

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
