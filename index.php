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
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background: #f5f7fa;
    }

    header {
        background: #333;
        color: white;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-buttons {
        display: flex;
        gap: 10px;
    }

    .header-buttons form {
        display: inline;
    }

    .header-buttons button {
        background: #4CAF50;
        border: none;
        padding: 8px 14px;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    .header-buttons button.logout {
        background: #f44336;
    }

    .container {
        margin: 40px auto;
        max-width: 800px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .expense-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .expense-row input, .expense-row select {
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 5px;
        flex: 1;
    }

    .submit-expense {
        background: #2196F3;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .add-btn {
        display: block;
        margin: 20px auto 0 auto;
        background: #4CAF50;
        color: white;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        font-size: 20px;
        cursor: pointer;
    }
</style>

</head>

<body>
  <!---------------------------navbaar start--------------------------------->

  <?php require_once "navbar.php" ?>

  <!---------------------------navbaar end --------------------------------->

<div class="container">
    <h3>Add Your Expenses</h3>
    <form method="POST" id="expenseForm">
        <div id="expenseRows">
            <div class="expense-row">
                <input type="text" name="item[]" placeholder="Item" required>
                <select name="category[]" required>
                    <option value="">Select Category</option>
                    <option value="Food">Food</option>
                    <option value="Transport">Transport</option>
                    <option value="Bills">Bills</option>
                    <option value="Shopping">Shopping</option>
                    <option value="Others">Others</option>
                </select>
                <input type="number" name="cost[]" placeholder="Cost" min="0" step="0.01" required>
            </div>
        </div>

        <button type="button" class="add-btn" id="addRow">+</button>
        <br><br>
        <button type="submit" name="submit_expense" class="submit-expense">Submit Expense</button>
    </form>
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
    document.getElementById('addRow').addEventListener('click', function() {
        const expenseRows = document.getElementById('expenseRows');
        const newRow = document.createElement('div');
        newRow.classList.add('expense-row');
        newRow.innerHTML = `
            <input type="text" name="item[]" placeholder="Item" required>
            <select name="category[]" required>
                <option value="">Select Category</option>
                <option value="Food">Food</option>
                <option value="Transport">Transport</option>
                <option value="Bills">Bills</option>
                <option value="Shopping">Shopping</option>
                <option value="Others">Others</option>
            </select>
            <input type="number" name="cost[]" placeholder="Cost" min="0" step="0.01" required>
        `;
        expenseRows.appendChild(newRow);
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
    });
  </script>
</body>
</html>
