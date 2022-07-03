<?php
    session_start();
    
    $json = file_get_contents('http://localhost:8000/user/cektoken/'.$_GET['token'].'/'.$_GET['id']);
    $obj = json_decode($json);
    $data = $obj->data;
    if ($data) {
        $_SESSION['token'] = $data->token;
        $_SESSION['nama'] = $data->nama;
        $_SESSION['id'] = $data->id;
        $_SESSION['status'] = $data->status;
        $_SESSION['username'] = $data->username;
        $_SESSION['email'] = $data->email;
        if ($data->status == "member") {
            header('location:http://localhost/tokobuku/index.php?site=beranda');
        }elseif ($data->status == "admin") {
            header('location:http://localhost/tokobuku/admin.php?site=buku');
        }
    }else{
        header('location:http://localhost/tokobuku/index.php?site=beranda');
    }
?>