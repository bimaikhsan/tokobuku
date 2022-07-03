<?php
switch ($_GET['site']) {
    case 'beranda':
        include "beranda.php";
        break;
    
    case 'login':
        include "login.php";
        break;

    case 'daftar':
        include "register.php";
        break;

    case 'keranjang':
        include "keranjang.php";
        break;
    case 'logout':
        session_destroy();
        header('location:http://localhost/tokobuku/index.php?site=beranda');
        break;

    default:
        echo "Error 404 Not Found";
        break;
}

?>