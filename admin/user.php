<div class="container">
<?php
if(!isset($_SESSION['token'])){
    header('location:http://localhost/tokobuku/admin.php?site=login');
}
if (isset($_GET['act'])) {
    if($_GET['act'] == 'tambah'){
    ?>
    <h1>Tambah user</h1>
    <form method="post">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="nama">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="username">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Status</label>

            <select name="status" class="form-control" id="status">
                <option value="member">member</option>
                <option value="admin">admin</option>
            </select><br>
        </div>
        <div class="mb-3">
            <input class="btn btn-primary" type="button" id="tambahdata" value="tambah User">
        </div>

    </form>
    <script>
        $(document).ready(function(){
            $('#tambahdata').click(function(){
                $.ajax({
                    url: 'http://localhost:8000/user/tambah/',
                    type: 'POST',
                    data:{
                        _method:"POST",
                        nama:document.getElementById("nama").value, 
                        username:document.getElementById("username").value, 
                        email:document.getElementById("email").value, 
                        password:document.getElementById("password").value, 
                        status:document.getElementById("status").value, 
                    },
                    success:function(response) {
                        window.location.href = 'http://localhost/tokobuku/admin.php?site=user';
                        console.log(response);
                    },
                });
            });
        });
    </script>
    <?php
    }elseif ($_GET['act'] == 'ubah') {
    $jsonubah = file_get_contents('http://localhost:8000/user/lihat/'.$_GET['id']);
    $objubah = json_decode($jsonubah);
    $dataubah = $objubah->data;
    ?>
    <h1>Ubah user : <?=$dataubah->nama?></h1>
    <form method="post">
        <input type="hidden" name="id" id="id" value="<?=$dataubah->id?>" placeholder="id"><br>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" value="<?=$dataubah->nama?>" placeholder="judul"><br>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username" value="<?=$dataubah->username?>" placeholder="harga"><br>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="<?=$dataubah->email?>" placeholder="email"><br>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Status</label>

            <select name="status" class="form-control" id="status">
            <?php
                if($dataubah->status == "member"){
                    ?>
                    <option value="member" selected>member</option>
                    <option value="admin">admin</option>
                    <?php
                }else{
                    ?>
                    <option value="admin" selected >admin</option>
                    <option value="member">member</option>
                    <?php
                }
                ?>
            </select><br>
        </div>
        <div class="mb-3">
            <input type="button" class="btn btn-primary" id="ubahdata" value="ubah User">
        </div>
    </form>
    <script>
        $(document).ready(function(){
            $('#ubahdata').click(function(){
                $.ajax({
                    url: 'http://localhost:8000/user/update/'+document.getElementById("id").value,
                    type: 'POST',
                    data:{
                        _method:"PUT",
                        nama:document.getElementById("nama").value, 
                        username:document.getElementById("username").value, 
                        email:document.getElementById("email").value, 
                        status:document.getElementById("status").value, 
                    },
                    success:function(response) {
                        window.location.href = 'http://localhost/tokobuku/admin.php?site=user';
                        console.log(response);
                    },
                });
            });
        });
    </script>
    <?php
    }elseif ($_GET['act'] == 'hapus') {
    ?>
    <script>
        $(document).ready(function(){
            $.ajax({
                url: 'http://localhost:8000/user/hapus/<?=$_GET["id"]?>',
                type: 'POST',
                data:{
                    _method:"DELETE"
                },
                success:function(response) {
                    window.location.href = 'http://localhost/tokobuku/admin.php?site=user';
                    console.log(response);
                },
            });
        });
    </script>
    <?php
    }elseif ($_GET['act'] == 'resetpass') {
    ?>
    <script>
        $(document).ready(function(){
            $.ajax({
                url: 'http://localhost:8000/user/resetpass/<?=$_GET["id"]?>',
                type: 'POST',
                data:{
                    _method:"POST"
                },
                success:function(response) {
                    window.location.href = 'http://localhost/tokobuku/admin.php?site=user';
                    console.log(response);
                },
            });
        });
    </script>
    <?php
    }
}
?>
<?php if (!isset($_GET['act'])) {
 ?>
<h1>Data User</h1>
<a class="btn btn-primary" href="admin.php?site=user&act=tambah">tambah</a>
<table id="example" class="table" style="width:100%">
    <thead>
    <tr>
        <td>No</td>
        <td>Nama</td>
        <td>Username</td>
        <td>Email</td>
        <td>Level</td>
        <td>Action</td>
    </tr>
    </thead>
    <tbody>
    <?php
    $json = file_get_contents('http://localhost:8000/user');
    $obj = json_decode($json);
    $data = $obj->data;
    $no = 0;
    foreach ($data as $value) {
        $no+=1;
        ?>
        <tr>
            <td><?=$no?></td>
            <td><?=$value->nama?></td>
            <td><?=$value->username?></td>
            <td><?=$value->email?></td>
            <td><?=$value->status?></td>
            <td><a class="btn btn-sm btn-warning" href='http://localhost/tokobuku/admin.php?site=user&act=resetpass&id=<?=$value->id?>'>reset pass</a> <a class="btn btn-success btn-sm" href='http://localhost/tokobuku/admin.php?site=user&act=ubah&id=<?=$value->id?>'>ubah</a> <a class="btn btn-danger btn-sm" href='http://localhost/tokobuku/admin.php?site=user&act=hapus&id=<?=$value->id?>'>hapus</a></td>
        </tr>
        <?php
    }
    ?>
    </tbody>

</table>
<div class="alert alert-primary" role="alert">
reset password = 12345678
</div>
</div>
<script>
    $(document).ready(function () {
    $('#example').DataTable();
});
</script>
<?php } ?>