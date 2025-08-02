<?php
  require_once "connectionDB.php";

  session_start();
  if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']!=true){
    header('location:'. './Login System/login.php');
    exit;
  }

  $sql = "SELECT expense, category, description, payment FROM expense";
  $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="styles.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Expense Managment</title>
</head>

<body>
  <!---------------------------navbaar start--------------------------------->

  <?php require_once "navbar.php" ?>

  <!---------------------------navbaar end --------------------------------->

  <div class="mx-auto h-screen w-75 md:w-96 mt-10 ">

  <div class="card bg-base-100 w-96 h-[38rem] shadow-lg">
  <div class="card-body items-center">
    <h2 class="card-title text-xl">Add Expense</h2>
    <form id="expenseForm" class="flex flex-col gap-4" action="connect.php" method="post">
      <!-- amount input -->

      <label for="expense">
        <span
          class="text-gray-700 mr-5 font-semibold after:ml-0.5 after:text-red-500 after:content-['*'] focus:border-indigo-600 focus:outline-hidden">Expense
          Amount: </span>
        <input type="number" name="expense" id="expense" placeholder="Enter Amount" required min="0.01" step="0.01"
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
        <option value="lunch">Lunch</option>
        <option value="dinner">Dinner</option>
        <option value="cha">Cha</option>
        <option value="coffee">Coffee</option>
        <option value="vara">Vara</option>
        <option value="medicine">Medicine</option>
        <option value="Utilities">Utilities</option>
        <option value="others">Others</option>
  </select>


      <!-- Description -->
      <label for="description">
        <span class=" mr-5 text-gray-700 font-semibold after:ml-0.5 after:text-red-500 after:content-['*'] focus:border-indigo-600 focus:outline-hidden">Description:
        </span>
        <textarea class=" w-full textarea mt-3" id="description" name="description"
          rows="4" placeholder="Add a description (e.g., Bought groceries, taxi fare)"></textarea>
      </label>

      <!-- Payment Method -->
      <label class="mr-5 font-semibold after:ml-0.5 after:text-red-500 after:content-['*']" for="payment">Payment Method :</label>

      <select class="select validator" name="payment" id="payment" required>
    <option disabled selected value="">Choose:</option>
        <option value="bKash">bKash</option>
        <option value="bKash">Cash</option>
        <option value="Nagad">Nagad</option>
        <option value="Rocket">Rocket</option>
        <option value="Card">Card</option>
  </select>

      <button class="mx-auto btn hover:bg-[#5d6d7e] hover:text-white transition-colors duration-200 w-1/2"  name="btnSubmit"
        type="submit">Submit
        Expense</button>

      <a href="viewNew.php" class="mx-auto mb-10 btn hover:bg-[#5d6d7e] hover:text-white transition-colors duration-200 w-1/2" name="viewExpense"
      type="submit">View
        Expense</a>
    </form>
  </div>
</div>


    <dialog id="my_modal_1" class="modal">
    <div class="modal-box">
        <p id="modal_message" class="py-4">Inserted Successfully</p>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Close</button>
            </form>
        </div>
    </div>
    </dialog>

 <script>
   document.getElementById('expenseForm').addEventListener("submit", function(e) {
      e.preventDefault();

      let formData = new FormData(this);

    
      fetch('connect.php', {
        method: "POST",
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        console.log("Response from PHP:", data);

        if (data === "success") {
          document.getElementById('modal_message').textContent = "Inserted Successfully!";
          document.getElementById('my_modal_1').showModal();
          document.getElementById('expenseForm').reset();
        }
         // Open modal
      })
      .catch(error => {
        console.error("Error:", error);
        document.getElementById('modal_message').textContent = "An unexpected error occurred.";
        document.getElementById('my_modal_1').showModal();
      });
    });
</script>

  </div>
</body>
</html>