<?php

    function generateFormToken($form) {
        $token = md5(uniqid(microtime(), true));
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

