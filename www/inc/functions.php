<?php

    session_start();

    function getRandomToken() {
        return md5(uniqid(microtime(), true));
    }

    function generateFormToken($form) {
        $token = getRandomToken();
        $_SESSION[$form.'_token'] = $token;
        return $token;
    }

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

    function logLine($line) {
        if ($handle = fopen('hacklog.log', 'a')) {
            fputs($handle, "\n << LOG >> $line\n\n");
            fclose($handle);
        };
    }

    function writeLog($where) {
        $ip = $_SERVER["REMOTE_ADDR"]; // Get the IP from superglobal
        $host = gethostbyaddr($ip);    // Try to locate the host of the attack
        $date = date("d M Y");
        $postData = str_replace("\n", "\n            ", print_r($_POST, true));
        $sessionData = str_replace("\n", "\n            ", print_r($_SESSION, true));

        $logging = <<<LOG
        \n
        << Start of Message >>
            There was a hacking attempt on your form. \n
            Date of Attack: {$date}
            IP-Adress: {$ip} \n
            Host of Attacker: {$host}
            Point of Attack: {$where}
            Post Data: {$postData}
            Session Data: {$sessionData}
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

    function verifyPostData($whitelist = array()) {
        foreach ($_POST as $key=>$item) {
            if (!in_array($key, $whitelist)) {
                writeLog('Unknown form fields');
                doError("Hack-Attempt detected. Please use only the fields in the form.");
            }
        }
    }

    function verifyEmail() {
        $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            writeLog('Email Validation');
            doError('Please insert a valid Email.');
        }
    }

    function verifyUrl() {
        if(!filter_var($_POST['u'], FILTER_VALIDATE_URL)) {
            writeLog('URL Validation');
            doError('Please insert a valid URL.');
        }
    }

    function getCurrentUrl() {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    function getCurrentUrlPage() {
        $url = getCurrentUrl();
        $end = strrpos($url, '.php');
        $start = strrpos($url, '/');
        return substr($url, $start + 1, $end - $start - 1);
    }

    function getPage($page) {
        $currentPage = getCurrentUrl();
        $pos = strrpos($currentPage, '/');
        return substr($currentPage, 0, $pos) . '/'.$page.'.php';
    }

    function redirect($page) {
        header('Location: '. getPage($page));
        die();
    }

    function doError($message) {
        $_SESSION['error'] = $message;
        redirect('error');
    }

    function config_read() {
        return parse_ini_file(__DIR__.'/../conf/viernes.ini');
    }

    function db_connect() {
        global $config;

        $con = mysqli_connect($config['host'],$config['username'],$config['password'],$config['db']);
        if(!$con){
            doError("Failed to connect to Database");
        }
        return $con;
    }

    function db_query($sql) {
        global $db;

        $result = $db->query($sql);

        $rows = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows []= $row;
            }
        }

        return $rows;
    }

    function db_insert($sql) {
        global $db;

        return $db->query($sql);
    }

    function db_update($sql) {
        global $db;

        return $db->query($sql);
    }

    function db_delete($sql) {
        global $db;

        return $db->query($sql);
    }

    function db_close() {
        global $db;

        $db->close();
    }

    function page_open() {
        $menu_options = array(
            "index"         => "Lista Viernes",
            "faq"           => "FAQ",
            "presentacion"  => "Presentación"
        );
        if (isset($_SESSION['usuario'])) {
            $menu_options['perfil'] = 'Mis datos';
            $menu_options['logout'] = 'Cerrar sesión';
        }
        echo '<!DOCTYPE HTML>';
        echo '<!--';
        echo '    Massively by HTML5 UP';
        echo '    html5up.net | @ajlkn';
        echo '    Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)';
        echo '-->';
        echo '<html>';
        echo '    <head>';
        echo '        <title>Lista Viernes</title>';
        echo '        <meta charset="utf-8" />';
        echo '        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />';
        echo '        <link rel="stylesheet" href="assets/css/main.css" />';
        echo '        <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>';
        echo '    </head>';
        echo '    <body class="is-loading">';
        echo '';
        echo '        <!-- Wrapper -->';
        echo '            <div id="wrapper">';
        echo '';
        echo '                <!-- Header -->';
        echo '                    <header id="header">';
        echo '                        <a href="index.php" class="logo"><img src="images/logo.png" /></a>';
        echo '                    </header>';
        echo '';
        echo '                <!-- Nav -->';
        echo '                    <nav id="nav">';
        echo '                        <ul class="links">';
        $currentPage = getCurrentUrlPage();
        foreach ($menu_options as $page => $text) {
            if ($page == $currentPage) {
                echo '                            <li class="active"><a href="' .
                    $page . '.php">' . $text . '</a></li>';
            } else {
                echo '                            <li><a href="' .
                    $page . '.php">' . $text . '</a></li>';
            }
        }
        echo '                        </ul>';
        echo '                        <ul class="icons">';
        echo '                            <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>';
        echo '                            <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>';
        echo '                            <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>';
        echo '                            <li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>';
        echo '                        </ul>';
        echo '                    </nav>';
        echo '';
        echo '                <!-- Main -->';
        echo '                <div id="main">';
    }

    function page_close() {
        db_close();
        echo '                </div>';
        echo '';
        echo '                <!-- Footer -->';
        echo '                    <footer id="footer">';
        echo '                    </footer>';
        echo '';
        echo '                <!-- Copyright -->';
        echo '                    <div id="copyright">';
        echo '                        <ul>';
        echo '                            <li>&copy; <a target="_blank" href="https://secuoyagroup.com/">Secuoya Group</a></li>';
        echo '                            <li>Design: <a target="_blank" href="https://html5up.net">HTML5 UP</a></li>';
        echo '                            <li>Distributor: <a target="_blank" href="https://themewagon.com">ThemeWagon</a></li>';
        echo '                        </ul>';
        echo '                    </div>';
        echo '';
        echo '            </div>';
        echo '';
        echo '        <!-- Scripts -->';
        echo '            <script src="assets/js/jquery.min.js"></script>';
        echo '            <script src="assets/js/jquery.scrollex.min.js"></script>';
        echo '            <script src="assets/js/jquery.scrolly.min.js"></script>';
        echo '            <script src="assets/js/skel.min.js"></script>';
        echo '            <script src="assets/js/util.js"></script>';
        echo '            <script src="assets/js/crypto-js.js"></script>';
        echo '            <script src="assets/js/main.js"></script>';
        echo '';
        echo '    </body>';
        echo '</html>';
    }

    function user_login() {
        global $config;

        if (!isset($_SESSION['usuario'])) {
            if (verifyFormToken('form_login')) {
                verifyPostData(array('token', 'email', 'pass', 'u'));
                verifyEmail();
                verifyUrl();
                $rows = db_query('SELECT * FROM ' . $config['tables.user'] . ' WHERE email = "' . $_POST['email'] . '" AND password = "' . $_POST['pass'] . '" AND activation_token IS NULL');
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
    }

    function user_logout() {
        unset($_SESSION['usuario']);
        unset($_SESSION['error']);
    }

    function user_get_logged_user() {
        return $_SESSION['usuario'];
    }

    function user_update_logged_user() {
        $usuario = $_SESSION['usuario'];
        $usuario['nombre']                     = $_POST['nombre'];
        $usuario['apellidos']                  = $_POST['apellidos'];
        $usuario['dni']                        = $_POST['dni'];
        $usuario['cp']                         = $_POST['cp'];
        $usuario['oposicion_ideologia']        = ( $_POST['oposicion_ideologia'] == 'on' ? 1 : 0 );
        $usuario['oposicion_propaganda_fijo']  = ( $_POST['oposicion_propaganda_fijo'] == 'on' ? 1 : 0 );
        $usuario['oposicion_propaganda_movil'] = ( $_POST['oposicion_propaganda_movil'] == 'on' ? 1 : 0 );
        $usuario['oposicion_propaganda_email'] = ( $_POST['oposicion_propaganda_email'] == 'on' ? 1 : 0 );
        $_SESSION['usuario'] = $usuario;
        return $_SESSION['usuario'];
    }

    function this_page_is_private() {
        if (!isset($_SESSION['usuario'])) {
            doError("No tienes permiso para acceder a esta página.");
        }
    }

    function user_register() {
        global $db;
        global $config;

        if (verifyFormToken('form_registro')) {
            verifyPostData(array('token', 'email', 'pass', 'confirm-vote', 'u'));
            verifyEmail();
            verifyUrl();
            $rows = db_query('SELECT * FROM ' . $config['tables.user'] . ' WHERE email = "' . $_POST['email'] . '"');
            if (count($rows) > 0) {
                doError('El email introducido corresponde a un usuario ya registrado y por tanto no se puede registrar de nuevo.');
            }
            $token_activation = getRandomToken();
            if (db_insert('INSERT INTO ' . $config['tables.user'] . '(email, password, activation_token) VALUES ("' . $_POST['email'] . '", "' . $_POST['pass'] . '", "' . $token_activation . '")') === true) {
                $rows = db_query('SELECT * FROM ' . $config['tables.user'] . ' WHERE email = "' . $_POST['email'] . '"');
                if (count($rows) != 1) {
                    doError('Se produjo un error inesperado al intentar registrar el usuario: <pre>' . $db->error . '</pre>');
                }
                if (db_insert('INSERT INTO ' . $config['tables.email'] . '(email, id_usuario) VALUES ("' . $_POST['email'] . '", ' . $rows[0]['id'] . ')') === true) {
                    // send email
                } else {
                    doError('Se produjo un error inesperado al intentar registrar el usuario: <pre>' . $db->error . '</pre>');
                }
            } else {
                doError('Se produjo un error inesperado al intentar registrar el usuario: <pre>' . $db->error . '</pre>');
            }
        } else {
            writeLog('form_registro');
            doError("Hack-Attempt detected. Got ya!.");
        }
        return $token_activation;
    }

    function user_activate() {
        global $db;
        global $config;

        $rows = db_query('SELECT * FROM ' . $config['tables.user'] . ' WHERE activation_token = "' . $_GET['token'] . '"');
        if (count($rows) != 1) {
            doError('Token no válido.');
        }
        if (db_update('UPDATE ' . $config['tables.user'] . ' SET activation_token = NULL WHERE activation_token = "' . $_GET['token'] . '"') === true) {
            // nothing?
        } else {
            doError('Token no válido.');
        }
    }

    function user_get_emails() {
        global $config;

        $usuario = user_get_logged_user();
        return db_query('SELECT id, email, id_usuario FROM ' . $config['tables.email'] . ' WHERE id_usuario = "' . $usuario['id'] . '"');
    }

    function user_get_tfnos() {
        global $config;

        $usuario = user_get_logged_user();
        return db_query('SELECT id, telefono, id_usuario FROM ' . $config['tables.phone'] . ' WHERE id_usuario = "' . $usuario['id'] . '"');
    }

    function perfil_delete_email() {
        global $db;
        global $config;

        if (verifyFormToken('form_delete_email_' . $_POST['id_email'])) {
            verifyPostData(array(
                'action', 'token', 'u',
                'id_email'
            ));
            verifyUrl();
            if (db_delete('DELETE FROM ' . $config['tables.email'] . ' WHERE id = ' . $_POST['id_email'])) {
                // all good
                $emails = user_get_emails();
            } else {
                doError('Se produjo un error inesperado al intentar borrar el email: <pre>' . $db->error . '</pre>');
            }
        } else {
            writeLog('form_delete_email_' . $_POST['id_email']);
            doError("Hack-Attempt detected. Got ya!.");
        }

        return $emails;
    }

    function perfil_delete_tfno() {
        global $db;
        global $config;

        if (verifyFormToken('form_delete_tfno_' . $_POST['id_tfno'])) {
            verifyPostData(array(
                'action', 'token', 'u',
                'id_tfno'
            ));
            verifyUrl();
            if (db_delete('DELETE FROM ' . $config['tables.phone'] . ' WHERE id = ' . $_POST['id_tfno'])) {
                // all good
                $tfnos = user_get_tfnos();
            } else {
                doError('Se produjo un error inesperado al intentar borrar el teléfono: <pre>' . $db->error . '</pre>');
            }
        } else {
            writeLog('form_delete_tfno_' . $_POST['id_tfno']);
            doError("Hack-Attempt detected. Got ya!.");
        }

        return $tfnos;
    }

    function perfil_add_email() {
        global $db;
        global $config;

        $usuario = user_get_logged_user();
        if (verifyFormToken('form_add_email')) {
            verifyPostData(array(
                'action', 'token', 'u',
                'email'
            ));
            verifyUrl();

            $sql = 'INSERT INTO ' . $config['tables.email'] . '(email, id_usuario) VALUES ("' . $_POST['email'] . '", ' . $usuario['id'] . ')';

            if (db_insert($sql)) {
                // all good
                $emails = user_get_emails();
            } else {
                logLine($sql);
                doError('Se produjo un error inesperado al intentar añadir el correo: <pre>' . $db->error . '</pre>');
            }
        } else {
            writeLog('form_add_email');
            doError("Hack-Attempt detected. Got ya!.");
        }

        return $emails;
    }

    function perfil_add_tfno() {
        global $db;
        global $config;

        $usuario = user_get_logged_user();
        if (verifyFormToken('form_add_tfno')) {
            verifyPostData(array(
                'action', 'token', 'u',
                'telefono'
            ));
            verifyUrl();
            if (db_insert('INSERT INTO ' . $config['tables.phone'] . '(telefono, id_usuario) VALUES ("' . $_POST['telefono'] . '", ' . $usuario['id'] . ')')) {
                // all good
                $tfnos = user_get_tfnos();
            } else {
                doError('Se produjo un error inesperado al intentar añadir el teléfono: <pre>' . $db->error . '</pre>');
            }
        } else {
            writeLog('form_add_tfno');
            doError("Hack-Attempt detected. Got ya!.");
        }

        return $tfnos;
    }

    function perfil_update() {
        global $db;
        global $config;

        $usuario = user_get_logged_user();
        if (verifyFormToken('form_perfil')) {
            verifyPostData(array(
                'action', 'token', 'u',
                'nombre', 'apellidos', 'dni', 'cp',
                'oposicion_ideologia',
                'oposicion_propaganda_fijo',
                'oposicion_propaganda_movil',
                'oposicion_propaganda_email'
            ));
            verifyUrl();
            if (db_update(
                'UPDATE ' . $config['tables.user'] . ' SET '
                . 'nombre     = "' . $_POST['nombre'] .'", '
                . 'apellidos  = "' . $_POST['apellidos'] .'", '
                . 'dni        = "' . $_POST['dni'] .'", '
                . 'cp         = "' . $_POST['cp'] .'", '
                . 'oposicion_ideologia        = "' . ( $_POST['oposicion_ideologia'] == 'on' ? 1 : 0 ) .'", '
                . 'oposicion_propaganda_fijo  = "' . ( $_POST['oposicion_propaganda_fijo'] == 'on' ? 1 : 0 ) .'", '
                . 'oposicion_propaganda_movil = "' . ( $_POST['oposicion_propaganda_movil'] == 'on' ? 1 : 0 ) .'", '
                . 'oposicion_propaganda_email = "' . ( $_POST['oposicion_propaganda_email'] == 'on' ? 1 : 0 ) .'" '
                . ' WHERE email = "' . $usuario['email'] . '"'
            ) === true) {
                // all good
                $usuario = user_update_logged_user();
            } else {
                doError('Se produjo un error inesperado al intentar actualizar los datos: <pre>' . $db->error . '</pre>');
            }
        } else {
            writeLog('form_perfil');
            doError("Hack-Attempt detected. Got ya!.");
        }

        return $usuario;
    }

    $config = config_read();
    $db = db_connect();

