<?php
if(!isset($_SESSION['token'])){
    header('location:http://localhost/tokobuku/admin.php?site=login');
}
?>
<div class="container">
<h1>Data Semua Transaksi</h1>
<table id="example" class="table" style="width:100%">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>username</th>
        <th>Buku</th>
        <th>Metode</th>
        <th>Total Buku</th>
        <th>Total Harga</th>
        <th>Waktu</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $json = file_get_contents('http://localhost:8000/transaksi');
    $obj = json_decode($json);
    $data = $obj->data;
    $no = 0;
    foreach ($data as $key => $value) {
        $datauser = file_get_contents('http://localhost:8000/user/lihat/'.$value->id_user); 
        $objuser = json_decode($datauser);
        $no+=1;
        ?>
        <tr>
            <td><?=$no?></td>
            <td>
                <?php
                    echo $objuser->data->nama;
                ?>
            </td>
            <td>
                <?php
                    echo $objuser->data->username;
                ?>
            </td>
            <td>
                <table>
                    <tr>
                        <td></td>
                        <td>Judul</td>
                        <td>Jumlah</td>
                        <td>Harga</td>
                        <td>Total</td>
                    </tr>
                <?php 
                $datax = json_decode($data[$key]->buku);
                foreach ($datax->data as $keyx => $valuex) {
                    if($valuex->jumlah != 0){
                        echo '<tr><td> - </td><td>'.$valuex->judul."</td>";
                        echo "<td>".$valuex->jumlah."</td><td>Rp.".$valuex->harga ."</td><td>Rp.".$valuex->jumlah*$valuex->harga."</td>";
                    }
                }?>
                </table>

            </td>
            <td><?=$value->metode?></td>
            <td><?=$datax->totalbuku?></td>
            <td>Rp.<?=$datax->totalharga?></td>
            <td><?=$value->created_at?></td>
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