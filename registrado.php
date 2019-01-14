<?php

    session_start();

    function verifyFormToken($form) {
        if(!isset($_SESSION[$form.'_token'])) {
            return false;
        }
        if(!isset($_POST['token'])) {
            return false;
        }
        if ($_SESSION[$form.'_token'] !== $_POST['token']) {
            return false;
        }
        return true;
    }

    function writeLog($where) {
        $ip = $_SERVER["REMOTE_ADDR"]; // Get the IP from superglobal
        $host = gethostbyaddr($ip);    // Try to locate the host of the attack
        $date = date("d M Y");
        $postData = str_replace("\n", "\n            ", print_r($_POST, true));

        $logging = <<<LOG
        \n
        << Start of Message >>
            There was a hacking attempt on your form. \n
            Date of Attack: {$date}
            IP-Adress: {$ip} \n
            Host of Attacker: {$host}
            Point of Attack: {$where}
            Post Data: {$postData}
        << End of Message >>

LOG;

        if ($handle = fopen('hacklog.log', 'a')) {
            fputs($handle, $logging);
            fclose($handle);
        } else {
            $to = 'ADMIN@gmail.com';
            $subject = 'HACK ATTEMPT';
            $header = 'From: ADMIN@gmail.com';
            if (mail($to, $subject, $logging, $header)) {
                echo "Sent notice to admin.";
            }
        }
    }

    if (verifyFormToken('form_registro')) {
        // ... more security testing
        // send email
    } else {
        echo "Hack-Attempt detected. Got ya!.";
        writeLog('form_registro');
        die();
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
                                    <h2>Bienvenido, Pepe</h2>
                                </header>


                                <h4>Comprueba tu correo para activar tu cuenta</h4>
                                <p>Comprueba tu bandeja de entrada en p******u@gmail.com, donde te hemos enviado un correo con un enlace para activar tu cuenta.</p>

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
            <script src="assets/js/main.js"></script>

    </body>
</html>
