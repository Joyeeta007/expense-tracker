<?php
  if(isset($_GET['logout'])){
    session_start();
    session_unset();
    session_destroy();
    header('location:'.'./Login System/login.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
</head>
<body>
<div class="navbar px-10 bg-[#5d6d7e] shadow-lg">
    <div class="flex-1">
      <a href='index.php' class="btn text-white btn-ghost text-xl">Expense Tracker</a>
    </div>
    <div class="flex-none">
      
    <a name='logout' href='?logout=true'  class="btn bg-white text-black hover:bg-[#5d6d7e] hover:text-white">Logout</a>
    </div>
  </div>
</body>
</html>