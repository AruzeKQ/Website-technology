<?php

$role = $_GET['role'];
if (isset($_GET["login"])) {
    if ($role === 'admin') {
        header("Location: admin.php");
        exit;
    } else {
        header("Location: user.php");
        exit;
    }
}

?>