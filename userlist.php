<?php 
include "displayTable.php";
session_start();
?>

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
            padding: 5px;
            
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
            background-color: #e3c5ff;
            background: linear-gradient(#e3c5ff, #6a4191 );
            
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            pointer-events: auto; 
        }
        label{
            font-weight: bold;   
        }

        .modal-content h2 {
            text-align: center;
            border-radius: 20px;
            padding: 10px;
  
            background-color: #6a4191;
            color: white;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            border: none;
            border-radius: 10px;
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 5px;
            text-align: center;
        }

        .button-group{
            border-radius: 20px;
            display: flex;
            /* background-color: #6a4191; */
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .button-group button {
            box-shadow: 5px 2px 10px rgba(0, 0, 0, .5);
            padding: 10px 15px;
            margin: 10px 5px 10px;
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
        /* Popup Styles */
        .confirmation-popup {
            backdrop-filter: blur(3px); 
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 1001;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        .popup-buttons {
            margin-top: 20px;
        }

        .popup-button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .clear-button{
            background-color: #393453;
            text-decoration: none;
            padding: 10px;
            justify-content: center;
            margin-left: 15px;
            border-radius: 20px;
            /* display: none; */
        }

        .clear-button:hover{
            background-color: #6a4191;
        }

        .popup-button:hover {
            background-color: #45a049;
        }
        .userNamediv{
            margin-top: 15px;
       
            font-weight: bold;
        }

        #cancelButton {
            background-color: #f44336;
        }

        #cancelButton:hover {
            background-color: #e53935;
        }

        #userIndex{
            width: 15%;
        }
        #ESP32SerialNumber{
            width: 30%;
        }
        #deletionProcessButton{
            padding: 10px;
            border-radius: 5px;
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
                <a class="button-profile-href" href="backendLogout.php"><img class="button-profile" src="src/svg/profile-icon.svg" alt="">logout</a>            
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
                <p>Search: <input type="text" placeholder="Username, Email" name="searchbar" value="<?php echo isset($_GET['searchbar']) ? htmlspecialchars($_GET['searchbar'], ENT_QUOTES) : '';?>">
                <a href="userlist.php" class="clear-button">clear</a>
                <a class="adduser-userlist-a" ><a class="adduser-userlist" href="addUserEnrollment.php" style="  

                padding-left: 20px;
                padding-top: 10px;
                padding-bottom: 10px;
                padding-right: 20px;"
                >+</a></a></p>
            </form>
            <table class="php-table">
                <tr>
                    <th>Fingerpint Index</th>
                    <th>Name</th>
                </tr>
                <?php 
                $count = 0;
                while($row = $result->fetch_assoc()){ ?>

                        <tr onclick="showEditUserModal('<?php echo $row['name']; ?>', '<?php echo $row['indexFingerprint']; ?>', '<?php echo $row['ESP32SerialNumber']; ?>')" id="rows-table" <?php if ($count % 2 == 0) echo 'class="even-color"'; ?>>
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
                
                <div class="form-group">
                    <label for="esp">Device: <input id="ESP32SerialNumber" name="ESP32SerialNumber" disabled> Index :  <input id="userIndex" name="userIndex" disabled></label>
                   
                    <div class="userNamediv">Change Name:</div>
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

    <!-- Confirmation Popup -->
    <div id="confirmationPopup" class="confirmation-popup">
        <div class="popup-content">
            <h3 id="popupMessage"></h3>
            <div class="popup-buttons">
                <button id="confirmButton" class="popup-button">Confirm</button>
                <button id="cancelButton" class="popup-button">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Deletion Process Modal -->
    <div id="deletionProcessModal" class="modal">
        <div class="modal-content">
            <h2 id="deletionProcessHeader">Deleting the Fingerprint...</h2>
            <button id="deletionProcessButton" class="save-btn" disabled>Processing</button>
        </div>
    </div>


    </div>

     <script>
        window.onload = function () {
        console.log("Script is running!");
        };
        let links = document.querySelectorAll('.page<?php echo $_GET['page-nr']?>');
        links[0].classList.add("active");

        function showEditUserModal(name1, indexFingerprint, ESP32SerialNumber) {
            console.log("This is running showEditUserModal");
            // Populate modal fields with data
            document.getElementById('userIndex').value = indexFingerprint;
            document.getElementById('userName').value = name1;
            document.getElementById('ESP32SerialNumber').value = ESP32SerialNumber;

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

        function showPopup(message, onConfirm) {
            const popupMessage = document.getElementById('popupMessage');
            const confirmationPopup = document.getElementById('confirmationPopup');
            const confirmButton = document.getElementById('confirmButton');
            const cancelButton = document.getElementById('cancelButton');

            // Set the message in the popup
            popupMessage.textContent = message;
            
            // Show the popup
            confirmationPopup.style.display = 'flex';

            // Set the onConfirm callback function
            confirmButton.onclick = () => {
                onConfirm(); // Execute the provided function (save or delete)
                closePopup(); // Close the popup after confirmation
            };

            // Close the popup if the user clicks "Cancel"
            cancelButton.onclick = closePopup;
        }

        function closePopup() {
            const confirmationPopup = document.getElementById('confirmationPopup');
            confirmationPopup.style.display = 'none'; // Hide the popup
        }

        function saveChanges() {
            const name = document.getElementById('userName').value;
            const index = document.getElementById('userIndex').value;

            if (name) {
                showPopup(`Are you sure you want to save changes?\nName: ${name}\nIndex: ${index}`, () => {
                    // Here you can add the logic to save data (e.g., sending it to the backend)
                    edituserDB();
                    
                    });
                } else {
                alert('Please fill out the name field before saving.');
    }
        }

        function confirmDelete() {
            const index = document.getElementById('userIndex').value;

            showPopup(`Are you sure you want to delete this user with index ${index}?`, () => {
            // Here you can add the logic to delete the user (e.g., sending a request to the backend)
            
            setFingerprintID();
            setOptionDelete();   
            verifyDeletion();

            // Optionally refresh the page or remove the deleted user row from the table
            });
        }
        async function doorlockDeleteOne(){
            const name = document.getElementById('userName').value;
            const index = document.getElementById('userIndex').value;
            const ESP32SerialNumber = document.getElementById('ESP32SerialNumber').value;

            
        const updateResponse = await fetch('deleteOneUser.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `name=${name}&index=${index}&ESP32SerialNumber=${ESP32SerialNumber}`
        });

        const updateData = await updateResponse.json();
        console.log('Update Data:', updateData);  // Log the response data

        if (updateData.status !== 'success') {
            console.error('Error enabling readmode fingerpint:', updateData);
            return;
        }
        }
        async function edituserDB(){
            const name = document.getElementById('userName').value;
            const index = document.getElementById('userIndex').value;
            const ESP32SerialNumber = document.getElementById('ESP32SerialNumber').value;

        const updateResponse = await fetch('update_nameonFingerprintDB.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `name=${name}&index=${index}&ESP32SerialNumber=${ESP32SerialNumber}`
        });

        const updateData = await updateResponse.json();
        console.log('Update Data:', updateData);  // Log the response data

        if (updateData.status !== 'success') {
            console.error('Error enabling readmode fingerpint:', updateData);

            return;
        }
        closeModal('editUserModal'); // Close the modal after saving
        document.location.reload() 
    }
    async function setFingerprintID() {
        //close nate yung modal, create new modal
        console.log("runnning setFingerprintID();")
        const index = document.getElementById('userIndex').value;
        const ESP32SerialNumber = document.getElementById('ESP32SerialNumber').value;

        const updateResponse = await fetch('save_fingerprint_index.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `fingerprintIndex=${index}`
        });

        const updateData = await updateResponse.json();
        console.log('Update Data:', updateData);  // Log the response data

        if (updateData.status !== 'success') {
            console.error('Error set ID fingerpint:', updateData);
            return;
        }
    }
    async function setOptionDelete(){
        const updateResponse = await fetch('update_option.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `option=2`
        });

        const updateData = await updateResponse.json();
        console.log('Update Data:', updateData);  // Log the response data

        if (updateData.status !== 'success') {
            console.error('Error enabling readmode fingerpint:', updateData);
            return;
        }
        doorlockDeleteOne(); 
    }

        async function verifyDeletion() {
        const index = document.getElementById('userIndex').value;
        const ESP32SerialNumber = document.getElementById('ESP32SerialNumber').value;

        // Show the deletion process modal
        const deletionModal = document.getElementById('deletionProcessModal');
        const header = document.getElementById('deletionProcessHeader');
        const button = document.getElementById('deletionProcessButton');
        deletionModal.style.display = 'flex';
        document.body.classList.add('modal-active'); // Add blur effect

        const interval = setInterval(async () => {
            try {
                console.log('Trying verification...');
                const response = await fetch(`verifyDeletion.php?serialNumber=${ESP32SerialNumber}&index=${index}`);
                const data = await response.json();

                if (data.status === 'success') {
                    clearInterval(interval);

                    // Update modal content to success
                    header.textContent = 'Successfully Deleted';
                    button.textContent = 'Done';
                    button.disabled = false;

                    // Add a listener to close the modal when "Done" is clicked
                    button.onclick = () => {
                        deletionModal.style.display = 'none';
                        document.body.classList.remove('modal-active'); // Remove blur effect
                        document.location.reload() 
                        };
                    }
                } catch (error) {
                    console.error('Error verifying deletion:', error);
                }
            }, 1000);
        }

    
     </script>                   
</body>
</html>