<div class="container">
<div class="row">
    <h1>Login</h1>
    <h1>Login</h1>
    <form method="post">

<div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" id="username" placeholder="username">
  </div>
  <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" id="password" placeholder="password">
  </div>
  <div class="mb-3">    
    <input type="button" class="btn btn-primary" id="login" value="Login">
  </div>
</div>
</div>
</form>
<script>
    $(document).ready(function(){
        $('#login').click(function(){
            $.ajax({
                url: 'http://localhost:8000/user/login',
                type: 'POST',
                data:{
                    _method:"POST",
                    username:document.getElementById("username").value, 
                    password:document.getElementById("password").value, 
                },
                success:function(response) {
                    
                    window.location.href = 'http://localhost/tokobuku/session.php?token='+response.data.token+'&id='+response.data.id;
                    console.log(response);
                },
                error:function(response) {
                    alert(response.responseJSON.message);
                    window.location.href = 'http://localhost/tokobuku/index.php?site=login';
                    console.log(response);
                },
            });
        });
    });
</script>