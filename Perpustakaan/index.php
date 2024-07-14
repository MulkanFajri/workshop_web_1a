<?php
session_start();
if (isset($_GET['x']) && $_GET['x'] == 'home') {
    $page = "home.php";
    include "main.php";
} elseif (isset($_GET['x']) && $_GET['x'] == 'pustaka') {
    $page = "pustaka.php";
    include "main.php";
} elseif (isset($_GET['x']) && $_GET['x'] == 'keranjang') {
    $page = "keranjang.php";
    include "main.php";
} elseif (isset($_GET['x']) && $_GET['x'] == 'peminjaman') {
    $page = "peminjaman.php";
    include "main.php";
} elseif (isset($_GET['x']) && $_GET['x'] == 'keterlambatan') {
    $page = "keterlambatan.php";
    include "main.php";
} elseif (isset($_GET['x']) && $_GET['x'] == 'denda') {
    $page = "denda.php";
    include "main.php";
} elseif (isset($_GET['x']) && $_GET['x'] == 'user') {
    if ($_SESSION['level_smartbook'] == 1) {
        $page = "user.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }

} elseif (isset($_GET['x']) && $_GET['x'] == 'login') {
    include "login.php";
} elseif (isset($_GET['x']) && $_GET['x'] == 'logout') {
    include "proses/proses_logout.php";
} else {
    $page = "home.php";
    include 'main.php';
}
?>