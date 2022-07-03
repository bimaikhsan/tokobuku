<form method="post">
<?php
    if (isset($_SESSION['token'])) {
        ?>
        <input type="submit" name="beli" class="btn btn-primary fixed-bottom"  value="Checkout" /><br>
        <?php
    }
?>
<div class="container">
<h2>Buku</h2>
    
    <div class="row">

    <h2>Buku</h2>

<?php
$json = file_get_contents('http://localhost:8000/buku');
$obj = json_decode($json);
$data = $obj->data;
foreach ($data as $value) {
    ?>
        <div class="col-sm-3" style="margin: 30px;">
            <div class="card" style="width: 18rem;">
                <img src="./server/storage/gambar/<?=$value->gambar?>" style="height:300px;margin:auto" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?=$value->judul?></h5>
                    <p class="card-text"><?=$value->deskripsi?></p>
                    
                    
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><p class="card-text">Tersedia : <?=$value->jumlah?></p></li>

                </ul>
                <div class="card-body">
                <a href="#" class="btn btn-primary">Rp.<?=number_format($value->harga,2,',','.')?></a>

                <input type="hidden" name="buku[<?php echo $value->id ?>]" value="<?php echo $value->judul ?>"/>
                <input type="hidden" name="harga[<?php echo $value->id ?>]" value="<?php echo $value->harga ?>"/>
                <div class="quantity buttons_added">
                    <input type="button" value="-" class="minus" />
                    <input type="number" class="input-text qty text" name="jumlah[<?php echo $value->id ?>]" value="0" min="0" max="<?=$value->jumlah?>" />
                    <input type="button" value="+" class="plus" />
                </div>    
                </div>
            </div>
        </div>
        
    <?php
    // foreach ($value as $keys => $values) {
    //     echo $values."<br>";
    // }
}
?>
</form>
<script>
            $(document).ready(function() {
			$('.minus').click(function () {
				var $input = $(this).parent().find('.input-text');
				var count = parseInt($input.val()) - 1;
				count = count < 0 ? 0 : count;
				$input.val(count);
				$input.change();
				return false;
			});
			$('.plus').click(function () {
				var $input = $(this).parent().find('.input-text');
                var count = parseInt($input.val()) + 1;
                var max = parseInt($input.attr('max'));
				count = count > max ? max : count;
				$input.val(count);
				$input.change();
				return false;
			});
		});
        </script>
     
<?php
    if (isset($_POST['beli'])) {
        $total = 0;
        $totalHarga = 0;
        $data = [];
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];
        $buku = $_POST['buku'];
        foreach ($jumlah as $keyx => $valuex) {
            $total+=$valuex;
        }
        if ($total != 0) {
            foreach ($harga as $key => $value) {
                $totalHarga+=$jumlah[$key]*intval($value);
                $data['data'][$key]['judul'] = $buku[$key];
                $data['data'][$key]['harga'] = $value;
                $data['data'][$key]['jumlah'] = $jumlah[$key];
            }
            $data['totalbuku']=$total;
            $data['totalharga']=$totalHarga;
        }else{
            $data = [];
            echo "<script>alert('Maaf Silahkan Pilih buku!');</script>";

        }
        if ($data != []) {
            
            ?>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <form method="post">

                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                <?php
                $no = 0;
                foreach ($data['data'] as $key => $values) {
                    $no+=1;
                    if ($values['jumlah']>0) {
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$values['judul']?></td>
                            <td><?=$values['jumlah']?></td>
                            <td>Rp.<?=number_format($values['harga'],2,',','.')?></td>
                            <td>Rp.<?=number_format($values['jumlah']*$values['harga'],2,',','.')?></td>
                        </tr>
                        <?php
                    }
                }
                echo "</table>";
                echo "<b>Total Buku = ".$data['totalbuku']."</b><br>";
                echo "<b>Total Bayar = Rp.".number_format($data['totalharga'],2,',','.')."</b><br>";
                ?>
                
                            <b>Metode Pembayaran<b> 
                            <select name="metode" class="form-control" id="metode">
                                <option value="langsung">Bayar Langsung</option>
                                <option value="langsung" disabled>Shoppe Pay</option>
                                <option value="langsung" disabled>Dana</option>
                                <option value="langsung" disabled>Bank</option>
                                <option value="langsung" disabled>Indomaret/Alfamart</option>
                                <option value="langsung" disabled>OVO</option>
                            </select>
                            <!-- <input type="button" id="bayar" value="Bayar"/> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="bayar" class="btn btn-primary">Bayar</button>
                </div>
                </div>
                </form>

            </div>
            </div>
            
            
            <script>
                $(window).on('load', function() {
        $('#exampleModal').modal('show');
    });
                $(document).ready(function(){
                    $('#bayar').click(function(){
                        $.ajax({
                            url: 'http://localhost:8000/transaksi/tambah',
                            type: 'POST',
                            data:{
                                _method:"POST",
                                id_user:"<?=$_SESSION['id']?>", 
                                metode:document.getElementById("metode").value, 
                                buku:'<?=json_encode($data)?>', 
                            },
                            success:function(response) {
                                window.location.href = 'http://localhost/tokobuku/admin.php?site=buku';
                                console.log(response);
                            },
                            error:function(response) {
                                alert("Maaf Buku Habis!");
                                window.location.href = 'http://localhost/tokobuku/admin.php?site=buku';
                                console.log(response);
                            },
                        });
                    });
                });
            </script>
            <?php
        }
    }elseif (isset($_POST['login'])) {
        header('location:http://localhost/tokobuku/index.php?site=login');
    }
?>

    </div>
</div>