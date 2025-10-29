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

  <div class="mt-10 w-full flex flex-col items-center">

    <form id="expenseForm" class="flex flex-col items-center gap-4" action="connect.php" method="post">

        <!-- Dynamic Rows Container -->
        <div id="expenseRows" class="flex flex-col gap-3">

            <!-- One Horizontal Row (Original inputs) -->
            <div class="flex items-center gap-4 flex-nowrap expense-row">

                <!-- Amount -->
                <label class="flex flex-col">
                    <span class="text-gray-700 text-sm font-semibold">Amount *</span>
                    <input type="number" name="expense[]" required min="0.01" step="0.01"
                    class="input input-bordered input-sm w-32" placeholder="Amount">
                </label>

                <!-- Category -->
                <label class="flex flex-col">
                    <span class="text-gray-700 text-sm font-semibold">Category *</span>
                    <select name="category[]" required class="select select-bordered select-sm w-32">
                        <option disabled selected value="">Choose</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                        <option value="cha">Cha</option>
                        <option value="coffee">Coffee</option>
                        <option value="vara">Vara</option>
                        <option value="medicine">Medicine</option>
                        <option value="Utilities">Utilities</option>
                        <option value="others">Others</option>
                    </select>
                </label>

                <!-- Description -->
                <label class="flex flex-col">
                    <span class="text-gray-700 text-sm font-semibold">Description *</span>
                    <input name="description[]" class="input input-bordered input-sm w-64" placeholder="Description">
                </label>

                <!-- Payment -->
                <label class="flex flex-col">
                    <span class="text-gray-700 text-sm font-semibold">Payment *</span>
                    <select name="payment[]" required class="select select-bordered select-sm w-32">
                        <option disabled selected value="">Choose</option>
                        <option value="bKash">bKash</option>
                        <option value="Cash">Cash</option>
                        <option value="Nagad">Nagad</option>
                        <option value="Rocket">Rocket</option>
                        <option value="Card">Card</option>
                    </select>
                </label>

            </div>

        </div>

        <!-- ➕ Add more row button -->
        <button type="button" id="addRowBtn" class="btn btn-circle btn-outline text-xl mt-2">+</button>

        <!-- Buttons (already centered by you earlier) -->
        <div class="w-full flex justify-center gap-4 mt-6">
            <button class="btn bg-[#0096FF] hover:bg-[#A7C7E7]
            btn-md text-white" name="btnSubmit" type="submit">Submit</button>
            <a href="viewNew.php" class="btn text-white bg-[#0096FF] 
            hover:bg-[#A7C7E7] btn-md" name="viewExpense">View</a>
        </div>

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

    document.getElementById("addRowBtn").addEventListener("click", function() {
    let row = document.querySelector(".expense-row").cloneNode(true);
    
    // Clear values for new row
    row.querySelectorAll("input, select").forEach(el => el.value = "");

    document.getElementById("expenseRows").appendChild(row);
});
</script>

  </div>
</body>
</html>