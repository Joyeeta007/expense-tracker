<?php
 
// Create connection
require "connectionDB.php";

// insert data
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $expense= $_POST['expense'];
    $category = $_POST['category'];
    $description= $_POST['description'];
    $payment= $_POST['payment'];

    $sql="
    Insert Into myguests(expense,category,entry_date,description,payment)
    values('$expense','$category',current_timestamp(),'$description','$payment')
";

if(mysqli_query($conn,$sql))
{
    echo "success";
}
else{
    die("Error" . mysqli_error($conn));
}
}

//show data
if(isset($_POST['viewExpense'])){
    require_once "viewNew.php";
}

?>