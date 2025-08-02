<?php

require_once "../connectionDB.php";

$passError='';
$email='';
if(isset($_GET['email'])){
    $email= $_GET['email'];
}
else{
    die('Invalid User.Please Register first');
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $newPass=$_POST['newPass'];
    $confirmNewPass=$_POST['confirmNewPass'];
    if($newPass != $confirmNewPass){
        $passError="Passwords do not match";
    }
    else{
        $sql="UPDATE logininfo SET user_password='$newPass' WHERE user_email='$email'";
        $result=mysqli_query($conn,$sql);
        if($result){
            header('location:'.'login.php');
            exit;
        }
        else{
            die('Error'.mysqli_error($conn));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Update</title>
</head>
<body>
<div class="hero w-full bg-base-200 min-h-screen h-full">
    <div class="hero-content flex flex-col">
      <div class="card bg-base-100 w-5xl max-w-sm shrink-0 shadow-2xl">
        <div class="card-body h-[500px] ">
        <form action="passUpdate.php?email=<?php echo $email ?>" method="post">
          <fieldset class="fieldset">
            <label class="fieldset-label text-sm text-black">New Password</label>
            <input type="password" name="newPass" class="input mb-5" placeholder="Your Password" />
            <label class="fieldset-label text-sm text-black">Confirm Password</label>
            <input type="password" name="confirmNewPass" class="input " placeholder="Confirm Password" />
            <p class="text-red-500 font-semibold">
              <?php
            if($_SERVER["REQUEST_METHOD"]=="POST" && ($passError)!='')
               echo $passError
              ?>
            </p>
           
            <button name="passUpdateBtn" class="btn bg-[#5d6d7e] hover:bg-white hover:text-black text-white mt-4">Update Password</button>
          </fieldset>
        </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>