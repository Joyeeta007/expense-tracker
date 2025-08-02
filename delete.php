<?php 
    require_once "connectionDB.php";
 if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql="DELETE FROM myguests WHERE id= $id";
        $result= mysqli_query($conn,$sql);
        if($result){
            echo "success";
        }
        else{
            die("Error occured :" . mysqli_error($conn));

        }
 }

?>