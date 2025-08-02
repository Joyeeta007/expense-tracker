<?php 
    require_once "../connectionDB.php";


    
    if(isset($_POST['enterBtn'])){
        $email=$_POST['email'];
        $sql="SELECT user_email FROM logininfo WHERE user_email='$email'";
        $result=mysqli_query($conn,$sql);
        $num=mysqli_num_rows($result);
        if($num>0){
           header("location:"."passUpdate.php?email=$email");
           exit;
        }
        else{
            die('Invalid user.Please Register');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
</head>
<body>
<div class="hero w-full bg-base-200 min-h-screen h-full">
    <div class="hero-content flex flex-col">
      <div class="card bg-base-100 w-5xl max-w-sm shrink-0 shadow-2xl">
        <div class="card-body h-[400px] ">
          <form id="passUpdateForm" action="forgetPass.php" method="post">
            <fieldset class="fieldset mt-10">
              <label class="fieldset-label text-sm text-black">Email</label>
              <input type="email" required name="email" class="input mb-5" placeholder="Your Email" />
              <button type='submit' name="enterBtn" class="btn bg-[#5d6d7e] hover:bg-white hover:text-black text-white mt-4">Enter</button>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>