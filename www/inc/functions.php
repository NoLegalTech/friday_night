<?php

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

