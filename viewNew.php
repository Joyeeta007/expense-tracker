<?php
    require_once "connectionDB.php";
    $sql = "SELECT id, expense, category, entry_date, description, payment FROM myguests";
    $result = mysqli_query($conn, $sql);
    $totalExpense = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>View</title>
</head>

<body>
    <?php require_once "navbar.php"; ?>
    <div class="relative mx-auto w-6xl mb-10 overflow-x-auto sm:rounded-lg">
        <div class='flex justify-center items-center'>
        <h2 class="text-[#2c3e50] text-center text-2xl ml-5 my-5 font-bold">Total Expense -
            <span id="totalExpense">0</span>
        </h2>
        </div>
        <table class="w-full border-x-2 border-b-2 dark:border-gray-200 text-sm text-left rtl:text-right text-gray-500 dark:text-black">
            <thead class="text-xs sm:rounded-lg shadow-md text-center text-gray-700 uppercase  dark:bg-[#5d6d7e] dark:text-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3">Record No.</th>
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3">Expense</th>
                    <th scope="col" class="px-6 py-3">Category</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Payment</th>
                    <th scope="col" class="px-6 text-center py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $count = 0;

                    while ($row = mysqli_fetch_assoc($result)) {
                        $count = $count + 1;
                        $totalExpense = $row['expense'] + $totalExpense;

                        echo "<tr class='odd:bg-white   text-center border-b dark:border-gray-200 border-gray-200'>
                            <th scope='row' class='px-6 text-center py-4 font-medium text-black whitespace-nowrap '>" . $count . "</th>
                            <td class='px-6 py-4'>" . $row['entry_date'] . "</td>
                            <td class='px-6 py-4'>" . $row['expense'] . "</td>
                            <td class='px-6 py-4'>" . $row['category'] . "</td>
                            <td class='px-6 py-4'>" . $row['description'] . "</td>
                            <td class='px-6 py-4'>" . $row['payment'] . "</td>
                            <td class='px-6 py-4 flex place-content-around'>
                                <a href='edit.php?id=" . $row['id'] . "' name='editBtn' class='btn hover:drop-shadow-lg hover:bg-blue bg-white font-medium text-blue-600'>
                                    <figure>
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='#FFFFFF' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6 hover:text-black'>
                                            <path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
                                        </svg>
                                    </figure>
                                </a>
                                <a href='#' data-id='" . $row['id'] . "' class='btn deleteBtn hover:drop-shadow-lg bg-white font-medium text-blue-600 hover:text-blue-500'>
                                    <figure>
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='#FFFFFF' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6 hover:text-black'>
                                            <path stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0' />
                                        </svg>
                                    </figure>
                                </a>
                            </td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="deleteModal" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-bold mb-4">Are you sure you want to delete this record?</h2>
            <div class="flex justify-between">
                <button id="confirmDelete" class="
                btn hover:bg-black hover:text-white bg-gray-300 transition-colors duration-200 w-1/2 mr-2
                 px-4 py-2 rounded">Delete</button>
                <button id="cancelDelete" class="btn hover:bg-black hover:text-white bg-gray-300 transition-colors duration-200 w-1/2
                 px-4 py-2 rounded">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        // Add event listeners for delete buttons
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default action (page reload)
                
                const recordId = this.getAttribute('data-id');
                const row = this.closest('tr'); // Find the closest <tr> (the row containing the button)
                
                // Show the modal
                const deleteModal = document.getElementById('deleteModal');
                deleteModal.classList.remove('hidden');
                
                // Confirm delete button
                const confirmDelete = document.getElementById('confirmDelete');
                confirmDelete.onclick = function() {
                    fetch('delete.php?id=' + recordId, {
                        method: 'GET',
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data==="success") {
                            row.remove(); // Remove the row from the DOM
                            deleteModal.classList.add('hidden'); // Hide the modal

                        } 
                        else {
                            alert('Error deleting record');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting record:', error);
                        alert('Error deleting record');
                    });
                };

                // Cancel delete button
                const cancelDelete = document.getElementById('cancelDelete');
                cancelDelete.onclick = function() {
                    deleteModal.classList.add('hidden'); // Close the modal
                };
            });
        });

        document.getElementById('totalExpense').textContent = "<?php echo $totalExpense; ?>/-";
    </script>
</body>
</html>
