<?php 
session_start();
if(!$_GET['site']){
    header("location:./index.php?site=beranda");
}
if(isset($_SESSION['token'])){
    if ($_SESSION['status'] == "admin") {
        header("location:./admin.php?site=beranda");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.min.js"></script>
    <script src="datatable.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="datatable.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Toko Buku</title>
</head>
<body>
    <?php 
        include "client/header.php";
        include "client/home.php";
        include "client/footer.php";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>