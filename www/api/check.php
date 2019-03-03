<?php

    require_once(__DIR__.'/../inc/functions.php');

    if (!isset($_POST['values'])) {
        echo '{"error":"No data"}';
        return;
    }

    $accepted = array();
    $rejected = array();
    foreach($_POST["values"] as $value) {
        if (admin_is_in_the_list($value)) {
            $rejected []= $value;
        } else {
            $accepted []= $value;
        }
    }

    echo json_encode(array(
        "accepted" => $accepted,
        "rejected" => $rejected
    ));
