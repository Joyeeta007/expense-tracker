<?php
  require_once "../connectionDB.php";
  $num=-1;
  $id=0;
  $email='';
  if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $sql="SELECT * FROM logininfo WHERE user_email='$email' AND user_password='$password' ";
    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);
    if($num>0){
      while($row=mysqli_fetch_assoc($result)){
        $id=$row['user_id'];
        $email=$row['user_email'];
      }
    }

    if($num==1){
      session_start();
      $_SESSION['loggedIn']=true;
      echo 'ongoing';
      header('location:'.'../index.php');
      exit();
    }
    else{
      $num=0;
    }
  } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Login</title>
</head>

<body>
  <div class="hero w-full bg-base-200 min-h-screen h-full">
    <div class="hero-content flex flex-col">
      <div class="text-center lg:text-center">
        <h1 class="text-4xl mb-4 text-[#2c3e50] font-bold">Login now!</h1>
      </div>
      <div class="card bg-base-100 w-5xl max-w-sm shrink-0 shadow-2xl">
        <div class="card-body h-[400px] ">
          <form id="loginForm" action="login.php" method="post">
            <fieldset class="fieldset mt-10">
              <label class="fieldset-label text-sm text-black">Email</label>
              <input type="email" required name="email" class="input mb-5" placeholder="Your Email" />
              <label class="fieldset-label text-sm text-black">Password</label>
              <input type="password" required name="password" class="input " placeholder="Your Password" />
              <a href="forgetPass.php" class='link link-hover'> Forget Password? </a>
             <div>
              <?php
              if($num===0){
                echo "<p class='text-red-500'>Wrong password or email </p>";
              }
              ?>
            </div>
              <button type='submit' name="loginBtn" class="btn bg-[#5d6d7e] hover:bg-white hover:text-black text-white mt-4">Login</button>
            </fieldset>
            <p class="flex justify-between mt-2">
              Didn't registered yet? <a href="register.php" class="link hover:text-red-500 link-hover mb-5 text-[#2471a3]">Register</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.getElementById('loginForm').addEventListener("submit",function(){
      e.preventDefault();
      document.getElementById('loginForm').reset();
    })
  </script>
</body>

</html>