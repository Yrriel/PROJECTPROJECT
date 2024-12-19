<?php include "displayTable.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/dashboard-style.css">
    <style>
            body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        body.modal-active {
            overflow: hidden; /* Prevent scrolling */
        }

        .modal {
            backdrop-filter: blur(3px); 
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7); /* Dark transparent overlay */
            justify-content: center;
            align-items: center;
            pointer-events: auto; 
        }

        .modal-content {

            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            pointer-events: auto; 
        }

        .modal-content h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        .button-group button {
            padding: 10px 15px;
            margin: 10px 5px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .save-btn {
            background-color: #4CAF50;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .close-btn {
            background-color: #888;
            color: white;
        }
    </style>
</head>
<body>
    <div id="">
        <div class="half-circle"></div>
        <div class="headerwrapper">
            <div class="header">
                <nav class="dash-nav">
                    <a class="button-menu-href" href="dashboard.php"><img class="button-menu" src="src/svg/icon-homeicon.svg" alt=""></a>
                    <a class="button-profile-href" href="login.html"><img class="button-profile" src="src/svg/profile-icon.svg" alt="">logout</a>
                </nav>
            </div>
            <div class="section">
                <div class="wrapper">
                    <div class="profile-container">
                        <span class="profile-container-span">
                            <img class="profile-picture" src="src/img/profile-sample.jpeg" alt="">
                            <span class="profile-text-box">
                                <h1>User list</h1>
                                <p>Click on any row to edit or delete.</p>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="message-alert-container">
            <div class="table-container">
                <form class="searchbar-container">
                    <p>Search: <input type="text" placeholder="Username, Email" name="searchbar" value="<?php echo isset($_GET['searchbar']) ? htmlspecialchars($_GET['searchbar'], ENT_QUOTES) : '';?>"> <a class="adduser-userlist-a" href="addUserEnrollment.php"><span class="adduser-userlist">add user</span></a></p>
                </form>
                <table class="php-table">
                    <tr>
                        <th>Fingerpint Index</th>
                        <th>Name</th>
                    </tr>
                    <?php 
                    $count = 0;
                    while($row = $result->fetch_assoc()){ ?>

                            <tr onclick="showEditUserModal('<?php echo $row['name']; ?>', '<?php echo $row['indexFingerprint']; ?>')" id="rows-table" <?php if ($count % 2 == 0) echo 'class="even-color"'; ?>>
                                <td><?php echo $row['indexFingerprint']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                            </tr>

                    <?php $count++; }?>
                </table>
                <div class="pagehere">
                    <div class="page-info">
                        <?php 
                            if(!isset($_GET['page-nr'])){
                                $_GET['page-nr'] = 1;
                                $page = 1;
                            }else{
                                $page = $_GET['page-nr'];
                            }
                        ?>
                        Showing <?php echo $page ?> of <?php echo $pages ?>
                    </div>
                    <div class="pagination">
                        <!-- first page -->
                        <?php if(isset($_GET['searchbar'])){?>
                            <a href="?searchbar=<?php echo $_GET['searchbar']?>&page-nr=1">First</a>
                        <?php } else{?>
                            <a href="?page-nr=1">First</a>
                        <?php }?>

                        <!-- previous page -->

                        <?php if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1){ 
                            if(isset($_GET['searchbar'])){?>
                                <a href="?searchbar=<?php echo $_GET['searchbar']?>&page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a>
                            <?php } else{ ?>
                                <a href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a>
                            <?php } }
                            else{
                            ?>
                                <a href="">Previous</a>
                            <?php } ?>

                        <!-- output the page numbers -->
                        <div class="page-numbers">

                            <?php 
                                for($i = 1; $i <= $pageVisible; $i++){
                                    
                                    if ( $_GET['page-nr'] > $pageMiddle && $_GET['page-nr'] < $pages-1 ){?> 
                                        <a class="page<?php echo $_GET['page-nr']-$pageMiddle + $i ?>" href="?page-nr=<?php echo $_GET['page-nr']-$pageMiddle + $i ?>"><?php echo $_GET['page-nr']-$pageMiddle + $i ?></a> <?php ; continue; }
                                    if( $_GET['page-nr'] <= $pageMiddle ){?> 
                                        <a class="page<?php echo $i ?>" href="?page-nr=<?php echo $i ?>"><?php echo $i ?></a> <?php ; continue; }
                                    if( $_GET['page-nr'] >= $pages-1 ){?>
                                        <a class="page<?php echo $pages - $pageVisible + $i ?>" href="?page-nr=<?php echo $pages - $pageVisible + $i ?>"><?php echo $pages - $pageVisible + $i ?></a> <?php ; continue; }
                                    ?>
                            <?php }?>

                        </div>

                        <!-- next page -->
                        <?php 
                        
                            if(!isset($_GET['page-nr'])){ 
                                if(isset($_GET['searchbar'])){ ?>
                                    <a href="?searchbar=<?php echo $_GET['searchbar']?>&page-nr=2">Next</a>
                                <?php } else{?>
                                    <a href="?page-nr=2">Next</a>
                                <?php }?>
                        <?php }else{
                            if($_GET['page-nr'] >= $pages){  ?>
                                <a href="">Next</a>
                            

                        <?php }else{
                            if(isset($_GET['searchbar'])){ ?>
                                    <a href="?searchbar=<?php echo $_GET['searchbar']?>&page-nr=<?php echo $_GET['page-nr'] + 1 ?>">Next</a>
                                <?php } else{?>
                                    <a href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>">Next</a>
                                <?php }?>
                        <?php } } ?> 

                        <!-- last page -->
                        <?php if(isset($_GET['searchbar'])){ ?>
                                    <a href="?searchbar=<?php echo $_GET['searchbar']?>&page-nr=<?php echo $pages?>">Last</a>
                                <?php } else{?>
                                    <a href="?page-nr=<?php echo $pages?>">Last</a>
                                <?php }?>
                    </div>
                </div>
            </div>
            
        </div>
    <!-- Modal Container -->
        <div id="editUserModal" class="modal">
            <div class="modal-content">
                <h2>Edit User</h2>
                <form id="editUserForm">
                    <input type="hidden" id="userIndex" name="userIndex">
                    <div class="form-group">
                        <label for="userName">Name</label>
                        <input type="text" id="userName" name="userName" placeholder="Enter name">
                    </div>
                    <div class="button-group">
                        <button type="button" class="save-btn" onclick="saveChanges()">Save Changes</button>
                        <button type="button" class="delete-btn" onclick="confirmDelete()">Delete User</button>
                        <button type="button" class="close-btn" onclick="closeModal('editUserModal')">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <script>
        let links = document.querySelectorAll('.page<?php echo $_GET['page-nr']?>');
        links[0].classList.add("active");

        function showEditUserModal(name, indexFingerprint) {
            // Populate modal fields with data
            document.getElementById('userIndex').value = indexFingerprint;
            document.getElementById('userName').value = name;

            // Show the modal
            document.getElementById('editUserModal').style.display = 'flex';

            // Add blur and dark background effect
            document.body.classList.add('modal-active');
        }

        function closeModal(modalId) {
            // Close the modal
            document.getElementById(modalId).style.display = 'none';

            // Remove blur and dark background effect
            document.body.classList.remove('modal-active');

            
        }

        function saveChanges() {
            const name = document.getElementById('userName').value;
            const index = document.getElementById('userIndex').value;

            if (name) {
                // Example of saving data (replace with actual backend logic)
                alert(`User updated successfully:\nName: ${name}\nIndex: ${index}`);
                closeModal('editUserModal');
            } else {
                alert('Please fill out the name field before saving.');
            }
        }

        function confirmDelete() {
            const index = document.getElementById('userIndex').value;

            if (confirm('Are you sure you want to delete this user?')) {
                // Example of deleting data (replace with actual backend logic)
                alert(`User with index ${index} deleted successfully.`);
                closeModal('editUserModal');
                // Optionally refresh the page or remove the deleted user row from the table
            }
        }

        

     </script>                   
</body>
</html>