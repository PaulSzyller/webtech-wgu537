<?php
    include('functions.php');

    session_start();
    destroySession();
    header("Location: login.html");
?>