<div class="container">
<?php
if(!isset($_SESSION['token'])){
    header('location:http://localhost/tokobuku/admin.php?site=login');
}
if (isset($_GET['act'])) {
    if($_GET['act'] == 'tambah'){
    ?>
    
    <?php
    }elseif ($_GET['act'] == 'ubah') {
    $jsonubah = file_get_contents('http://localhost:8000/buku/lihat/'.$_GET['id']);
    $objubah = json_decode($jsonubah);
    $dataubah = $objubah->data;
    ?>
    <h1>Ubah buku <?=$dataubah->judul?></h1>
    <form method="post">
        <input type="hidden" name="id" id="id" value="<?=$dataubah->id?>" placeholder="id">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Judul</label>
            <input type="text" name="judul" value="<?=$dataubah->judul?>" class="form-control" id="judul" placeholder="judul">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Harga</label>
            <input type="text" name="harga" class="form-control" id="harga" value="<?=$dataubah->harga?>" placeholder="harga"><br>

        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1"  class="form-label">Jumlah</label>
            <input type="number" name="jumlah"  class="form-control" id="jumlah" value="<?=$dataubah->jumlah?>" min="0" placeholder="jumlah"><br>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" cols="30" rows="10" id="deskripsi" placeholder="deskripsi"><?=$dataubah->deskripsi?></textarea><br>
        </div>
        <div class="mb-3">
            <input type="button" class="btn btn-primary" id="ubahdata" value="ubah buku">
        </div>
    </form>
    <script>
        $(document).ready(function(){
            $('#ubahdata').click(function(){
                $.ajax({
                    url: 'http://localhost:8000/buku/update/'+document.getElementById("id").value,
                    type: 'POST',
                    data:{
                        _method:"PUT",
                        judul:document.getElementById("judul").value, 
                        harga:document.getElementById("harga").value, 
                        jumlah:document.getElementById("jumlah").value, 
                        deskripsi:document.getElementById("deskripsi").value, 
                    },
                    success:function(response) {
                        window.location.href = 'http://localhost/tokobuku/admin.php?site=buku';
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
                url: 'http://localhost:8000/buku/hapus/<?=$_GET["id"]?>',
                type: 'POST',
                data:{
                    _method:"DELETE"
                },
                success:function(response) {
                    window.location.href = 'http://localhost/tokobuku/admin.php?site=buku';
                    console.log(response);
                },
            });
        });
    </script>
    <?php
    }
}
?>
<?php if (isset($_GET["act"]) != "ubah") {
?>
<h1>Halaman Buku</h1>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahbukuModal">
  Tambah Buku
</button>
<div class="modal fade" id="tambahbukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <form method="post" enctype="multipart/form-data">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" id="judul" placeholder="judul">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Harga</label>
            <input type="text" name="harga" class="form-control" id="harga" placeholder="harga">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Gambar</label>
            <input type="file" class="form-control" name="gambar" id="gambar">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" id="jumlah" min="0" placeholder="jumlah">

        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Deskripsi</label>
        <textarea name="deskripsi" cols="30" class="form-control" rows="10" id="deskripsi" placeholder="deskripsi"></textarea>

        </div>

    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="tambahdata" class="btn btn-primary">Tambah Buku</button>
      </div>
      <script>
        $(document).ready(function(){
            $('#tambahdata').click(function(){
                var formData = new FormData();
                formData.append('_method','POST');
                formData.append('judul',document.getElementById("judul").value);
                formData.append('harga',document.getElementById("harga").value);
                formData.append('jumlah',document.getElementById("jumlah").value);
                formData.append('deskripsi',document.getElementById("deskripsi").value); 
                formData.append('gambar',document.getElementById("gambar").files[0],document.getElementById("gambar").files[0].name);
                $.ajax({
                    url: 'http://localhost:8000/buku/tambah/',
                    type: 'POST',
                    processData: false, 
                    contentType: false,
                    data: formData,
                    success:function(response) {
                        window.location.href = 'http://localhost/tokobuku/admin.php?site=buku';
                        console.log(response);
                    },
                });
            });
        });
    </script>
    </form>
    </div>
  </div>
</div>
<table id="example" class="table" style="width:100%">
    <thead>
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>deskripsi</th>
        <th>Gambar</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $json = file_get_contents('http://localhost:8000/buku');
    $obj = json_decode($json);
    $data = $obj->data;
    $no = 0;
    foreach ($data as $value) {
        $no+=1;
        ?>
        <tr>
            <td><?=$no?></td>
            <td><?=$value->judul?></td>
            <td><?=$value->jumlah?></td>
            <td>Rp.<?=$value->harga?></td>
            <td><?=$value->deskripsi?></td>
            <td><img width="100px" src="./server/storage/gambar/<?=$value->gambar?>" alt="<?=$value->gambar?>"></td>
            <td><a class="btn btn-sm btn-primary" href='./server/storage/gambar/<?=$value->gambar?>' target='_blank'>lihat gambar</a> <a class="btn btn-sm btn-success" href='http://localhost/tokobuku/admin.php?site=buku&act=ubah&id=<?=$value->id?>'>ubah</a>  <a class="btn btn-sm btn-danger" href='http://localhost/tokobuku/admin.php?site=buku&act=hapus&id=<?=$value->id?>'>hapus</a></td>
        </tr>
        <?php
    }
    ?>
    </tbody>

</table>
</div>
<script>
    $(document).ready(function () {
    $('#example').DataTable();
});
</script>
<?php } ?>