<?php
 
// Create connection
require "connectionDB.php";

// insert data
if(isset($_POST['expense'])){
    foreach($_POST['expense'] as $index => $exp){
        $cat = $_POST['category'][$index];
        $desc = $_POST['description'][$index];
        $pay = $_POST['payment'][$index];

        $sql = "INSERT INTO myguests (expense, category, payment, description)
                VALUES ('$exp', '$cat', '$pay', '$desc')";
        mysqli_query($conn, $sql);
    }
    echo "success";
}


//show data
if(isset($_POST['viewExpense'])){
    require_once "viewNew.php";
}

?>