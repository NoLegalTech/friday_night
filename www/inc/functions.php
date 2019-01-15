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

    function getPage($page) {
        $currentPage = $_POST['u'];
        $pos = strrpos($currentPage, '/');
        return substr($currentPage, 0, $pos) . '/'.$page.'.php';
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

    function doError($message) {
        $_SESSION['error'] = $message;
        header('Location: '. getPage('error'));
        die();
    }

    function db_connect() {
        $config = parse_ini_file(__DIR__.'/../../conf/viernes.ini');
        $con = mysqli_connect("localhost",$config['username'],$config['password'],$config['db']);
        if(!$con){
            doError("Failed to connect to Database");
        }
        return $con;
    }

    function db_query($db, $sql) {
        $result = $db->query($sql);

        $rows = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows []= $row;
            }
        }

        return $rows;
    }

    function db_insert($db, $sql) {
        return $db->query($sql);
    }

    function db_update($db, $sql) {
        return $db->query($sql);
    }

    function db_close($db) {
        $db->close();
    }

    function page_open() {
        $menu_options = array(
            "index"         => "Lista Viernes",
            "faq"           => "FAQ",
            "presentacion"  => "Presentación"
        );
        if (isset($_SESSION['usuario'])) {
            $menu_options['perfil'] = 'Mi perfil';
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
        echo '                        <a href="index.php" class="logo">Lista viernes</a>';
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
        echo '                    <div id="main">';
    }

    function page_close() {
    }
