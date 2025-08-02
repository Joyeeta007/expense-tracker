<?php 
    require_once "connectionDB.php";

    if(isset($_GET['id'])){
     $id=$_GET['id'];
    }
    else {
        die("Error: No ID provided.");
    }

    $sql = "SELECT expense,description,category,payment FROM myguests WHERE id=$id ";
    $result=mysqli_query($conn,$sql);
    if(!$result){
        die("Error". mysqli_error($conn));
    } 
    
    while($row=mysqli_fetch_assoc($result)){
        $expense= $row['expense'];
        $description=$row['description'];
        $category=$row['category'];
        $payment=$row['payment'];
    }
    

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $expense= $_POST['expense'];
        $description= $_POST['description'];
        $category= $_POST['category'];
        $payment= $_POST['payment'];

        $sql="UPDATE myguests SET expense='$expense', description='$description',
        category='$category', payment='$payment'
        where id=$id
        ";
        $result=mysqli_query($conn,$sql);
        if($result){
            echo "success";
            exit;
        }
        else{
            die("Error" . mysqli_error($conn));
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
    <title>Edit Expense</title>
</head>
<body>

<?php require_once "navbar.php" ?>
<div class="mx-auto h-screen w-75 md:w-96 mt-5 ">

<div class="card mb-10 bg-base-100 w-96 h-[36rem] shadow-lg">
<div class="card-body items-center">
  <h2 class="card-title">Update Expense</h2>
<form id="updateForm"  class="flex flex-col gap-4" action="edit.php?id=<?php echo $id?>" method="post">
    <!-- amount input -->
    <label for="expense">
      <span
        class="text-gray-700 mr-5 font-semibold after:ml-0.5 after:text-red-500 after:content-['*'] focus:border-indigo-600 focus:outline-hidden">Expense
        Amount: </span>
      <input type="number" name="expense" id="expense" placeholder="Enter Amount" required min="0.01" step="0.01"
      value="<?php echo $expense ?>"
        class="w-full mt-3 input input-lg">
    </label>

    <!-- Expense Category -->
    <label for="category">
      <span
        class="text-gray-700 font-semibold mr-5 after:ml-0.5 after:text-red-500 after:content-['*'] focus:border-indigo-600 focus:outline-hidden">Category
        :</span>
    </label>
    <select class="select validator input input-lg" name="category"  id="category" required>
  <option disabled selected value="">Choose:</option>
      <option value="lunch" <?php if("lunch"===$category) echo 'selected' ?>>Lunch</option>
      <option value="dinner" <?php if($category==='dinner') echo 'selected' ?>>Dinner</option>
      <option value="cha" <?php if($category==='cha') echo 'selected' ?>>cha</option>
      <option value="coffee" <?php if($category==='coffee') echo 'selected' ?>>Coffee</option>
      <option value="vara" <?php if($category==='vara') echo 'selected' ?>>Vara</option>
      <option value="Medicine" <?php if($category==='Medicine') echo 'selected' ?>>Medicine</option>
      <option value="Utilities" <?php if($category==='Utilities') echo 'selected' ?>>Utilities</option>
      <option value="others" <?php if($category==='others') echo 'selected' ?>>Others</option>
</select>

    <!-- Description -->
    <label for="description">
      <span class=" mr-5 text-gray-700 font-semibold after:ml-0.5 after:text-red-500 after:content-['*']">Description:
      </span>
      <textarea class=" w-full textarea mt-3" id="description" name="description"
        rows="4" placeholder="Add a description (e.g., Bought groceries, taxi fare)">
        <?php echo $description ?>
    </textarea>
    </label>

    <!-- Payment Method -->
    <label class="mr-5 font-semibold after:ml-0.5 after:text-red-500 after:content-['*']" for="payment">Payment Method :</label>

    <select class="select validator" name="payment" id="payment" required>
  <option disabled selected value="">Choose:</option>
      <option value="bKash" <?php if($payment==='bKash') echo 'selected' ?>>bKash</option>
      <option value="Cash" <?php if($payment==='Cash') echo 'selected' ?>>Cash</option>
      <option value="Nagad" <?php if($payment==='Nagad') echo 'selected' ?>>Nagad</option>
      <option value="Rocket" <?php if($payment==='Rocket') echo 'selected' ?>>Rocket</option>
      <option value="Card" <?php if($payment==='Card') echo 'selected' ?>>Card</option>
</select>

      <button class="mx-auto btn hover:bg-black hover:text-white transition-colors duration-200 w-1/2" name="btnSave"
        type="submit">Save Expense
        </button>
  </form>
</div>
</div>

<dialog id="updateModal" class="modal">
    <div class="modal-box">
        <p id="modal_message" class="py-4">Updated Successfully</p>
        <div class="modal-action">
            <form method="dialog">
                <button id="closeModalBtn" class="btn">Close</button>
            </form>
        </div>
    </div>
</dialog>

<script>
    document.getElementById('updateForm').addEventListener("submit",function(e){
        e.preventDefault();

        let formData=new FormData(this);
        console.log(formData);
        

        fetch("edit.php?id=<?php echo $id; ?>", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    
    .then(data => {
        if (data === "success") {  
            modalMsg=document.getElementById('modal_message');
            modalMsg.textContent = "Updated Successfully";

            document.getElementById('updateModal').showModal();  // Show modal
            document.getElementById('updateForm').reset();
        }
    })
    .catch(error => console.log("Error:", error));
    
});

document.getElementById("closeModalBtn").addEventListener("click", function() {
    window.location.href = "viewNew.php"; 
});
</script>

</body>
</html>