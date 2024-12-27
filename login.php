<!DOCTYPE html>
<html lang="en">
<?php 
  session_start();
  include('./db_connect.php');
    ob_start();
    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
    ob_end_flush();
?>
<?php 
  if(isset($_SESSION['login_id']))
  header("location:index.php?page=home");
?>
<?php include 'header.php' ?>


<body class="hold-transition login-page bg-dark">
<!--page content-->
<div class="vh-100 vw-100 d-flex flex-row align-items-center justify-content-center">
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: -10;">
        <img src="assets/images/login_background.jpg" alt="Lmao" class="w-100 h-100 object-cover" style="filter: blur(2px);"/>  
    </div>

    <!-- Login Box -->
    <div class="d-flex flex-col w-50 p-3 bg-white rounded rounded-4 shadow-lg overflow-hidden" style="max-width: 100%;">  
        
        <!-- Left Side -->
        <div class="d-none d-lg-flex flex-column align-items-center justify-content-center" style="width: 50%;">
            <img src="assets/images/logo.png" alt="Company Logo" style="width: 170px; height: 170px;">
            <h3 class="text-lg text-black text-center" style="font-family: 'Bebas Neue', cursive;">Trackstorm</h3>  
        </div>

        <!-- Divider -->
        <div class="d-none d-lg-flex mr-3 my-3 border-end border-2 border-dark" style="--bs-border-opacity: 0.7;">
        </div>

        <!-- Right Side -->
        <div class="w-100 p-4" style="width: 50%;">
            <h2 class="text-2xl font-semibold text-gray-700 text-center">Login</h2>
            <p class="text-lg text-gray-600 text-center">Welcome back!</p>
            <form action="" id="login-form">
                <div class="mt-4">
                    <label class="form-label text-gray-700 text-sm font-bold mb-2">Username</label>
                    <div class="input-group mb-3">
                      <input type="email" class="form-control" name="email" required placeholder="Email">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="form-label text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" class="form-control" name="password" required placeholder="Password">
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    <Button type="submit" class="btn btn-dark py-2 mb-3 px-4">Login</Button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  $(document).ready(function(){
    $('#login-form').submit(function(e){
      e.preventDefault();
      start_load();
      // if($(this).find('.alert-danger').length > 0 )
      //   $(this).find('.alert-danger').remove();
      $.ajax({
        url:'ajax.php?action=login',
        method:'POST',
        data:$(this).serialize(),
        error:err=>{
          console.log(err);
          end_load();
        },
        success:function(resp){
          if(resp == 1){
            location.href ='index.php?page=home';
          }else{
            $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
            end_load();
          }
        }
      });
    });
  });
</script>
<?php include 'footer.php' ?>
</body>
</html>
