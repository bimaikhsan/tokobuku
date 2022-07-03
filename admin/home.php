<?php
switch ($_GET['site']) {
    
    case 'login':
        include "login.php";
        break;

    case 'buku':
        include "buku.php";
        break;
    case 'user':
        include "user.php";
        break;
    case 'transaksi':
        include "transaksi.php";
        break;
    case 'logout':
        session_destroy();
        header('location:http://localhost/tokobuku/admin.php?site=buku');
        break;


    default:
        echo "Error 404 Not Found";
        break;
}

?>