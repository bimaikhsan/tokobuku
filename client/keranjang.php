<?php
if(!isset($_SESSION['token'])){
    header('location:http://localhost/tokobuku/index.php?site=login');
}
$json = file_get_contents('http://localhost:8000/transaksi/lihatid/'.$_SESSION['id']);
$obj = json_decode($json);
$data = $obj->data;
?>
<div class="container">
    <br>
    <br>
    <br>
    <h1>Data Transaksi Keranjang</h1>
<table id="example" class="table" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Data Buku</th>
            <th>Metode Pembayaran</th>
            <th>Total Buku</th>
            <th>Total Harga</th>
            <th>Waktu</th>
        </tr>
    </thead>
    

<tbody>

<?php
$no = 0;
foreach ($data as $key => $value) {
    $no+=1;
    ?>
        <tr>
            <td><?=$no?></td>
        
        <?php
        echo "<td>";
        echo "<table><tr><td></td><td>Judul</td><td>Jumlah</td><td>Harga</td><td>Total</td>";
        $datax = json_decode($data[$key]->buku);
        foreach ($datax->data as $keyx => $valuex) {
            if($valuex->jumlah != 0){
                echo '<tr><td> - </td><td>'.$valuex->judul."</td>";
                echo "<td>".$valuex->jumlah."</td><td>Rp.".$valuex->harga ."</td><td>Rp.".$valuex->jumlah*$valuex->harga."</td>";
                echo '</tr>';
            }
        }
        echo "</table>";
        echo "</td>";
        echo "<td>".$data[$key]->metode."</td>";
        echo "<td>".$datax->totalbuku."</td>"; 
        echo "<td>Rp.".number_format($datax->totalharga,2,',','.')."</td>";
        echo "<td>".$data[$key]->created_at."</td>";
        ?>
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