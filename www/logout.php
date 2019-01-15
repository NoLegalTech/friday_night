<?php

    require_once(__DIR__.'/inc/functions.php');

    unset($_SESSION['usuario']);
    unset($_SESSION['error']);
    redirect('index');

