<div class="container">
    <div class="row">
        <h1>Daftar</h1>
        <h1>Daftar</h1>
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
        <label for="exampleFormControlTextarea1" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="password">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com">
      </div>
      <div class="mb-3">    
        <input type="button" class="btn btn-primary" id="daftar" value="Daftar">
      </div>
    </div>
    </div>
    </form>
<script>
    $(document).ready(function(){
        $('#daftar').click(function(){
            $.ajax({
                url: 'http://localhost:8000/user/tambah',
                type: 'POST',
                data:{
                    _method:"POST",
                    nama:document.getElementById("nama").value, 
                    username:document.getElementById("username").value, 
                    password:document.getElementById("password").value, 
                    email:document.getElementById("email").value, 
                },
                success:function(response) {
                    window.location.href = 'http://localhost/tokobuku/index.php?site=login';
                    console.log(response);
                },
                error:function(response) {
                    alert(response.responseJSON.message);
                    window.location.href = 'http://localhost/tokobuku/index.php?site=daftar';
                    console.log(response);
                },
            });
        });
    });
</script>