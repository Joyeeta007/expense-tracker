
<?php
  require_once "../connectionDB.php";
  $passError='';
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    $confirmPass=$_POST['confirmPass'];
    if($pass != $confirmPass && !empty($passError)){
      $passError="Password doesn't match";
    }
    if($email){
      $existSql="SELECT user_email FROM logininfo WHERE user_email='$email'";
      $result=mysqli_query($conn,$existSql);
      if(mysqli_num_rows($result)>0){
        echo "
        <div role='alert' class='alert alert-error'>
          <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 shrink-0 stroke-current' fill='none' viewBox='0 0 24 24'>
            <path stroke-linecap='' stroke-linejoin='' stroke-width='2'   d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />
          </svg>
          <span>Username already in use.Please login!</span>
        </div>
          ";
      }
      else{
        $passError='';
        $sql="INSERT INTO logininfo(user_email,user_password) VALUES('$email','$pass')";
        if(mysqli_query($conn,$sql)){
          echo "
          <div role='alert' class='alert alert-success'>
            <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 shrink-0 stroke-current' fill='none' viewBox='0 0 24 24'>
              <path stroke-linecap='' stroke-linejoin='' stroke-width='2'   d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />
            </svg>
            <span>You have successfully registered. Please login now!</span>
          </div>
            ";
        }
        else{
          die("Error" . mysqli_error($conn));
        }
      }
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
  <title>Register</title>
</head>

<body>
  <div class="hero w-full bg-base-200 min-h-screen h-full">
    <div class="hero-content flex flex-col">
      <div class="text-center lg:text-center">
        <h1 class="text-4xl mb-4 font-bold">Register now!</h1>
      </div>
      <div class="card bg-base-100 w-5xl max-w-sm shrink-0 shadow-2xl">
        <div class="card-body h-[500px] ">
        <form action="register.php" method="post">
          <fieldset class="fieldset">
            <label class="fieldset-label text-sm text-black">Name</label>
            <input type="text" class="input mb-5" name="name" placeholder="Your Name" />
            <label class="fieldset-label text-sm text-black">Email</label>
            <input type="email" class="input mb-5" name="email" placeholder="Your Email" />
            <label class="fieldset-label text-sm text-black">Password</label>
            <input type="password" name="pass" class="input mb-5" placeholder="Your Password" />
            <label class="fieldset-label text-sm text-black">Confirm Password</label>
            <input type="password" name="confirmPass" class="input " placeholder="Confirm Password" />
            <p class="text-red-500 font-semibold">
              <?php
            if($_SERVER["REQUEST_METHOD"]=="POST" && ($passError)!='')
               echo $passError
              ?>
            </p>
           
            <button name="registerBtn" class="btn bg-[#5d6d7e] hover:bg-white hover:text-black text-white mt-4">Register</button>
          </fieldset>
        </form>
          <div class="flex justify-between">Already Registered?<a href="login.php" class="link ml-5 link-hover text-red-500 mb-5">Login</a></div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>