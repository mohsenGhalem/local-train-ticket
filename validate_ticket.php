<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (empty($_SESSION['user_info'])) {
    echo "<script type='text/javascript'>alert('Please login before proceeding further!');location.href='login.php'</script>";
}
$conn = mysqli_connect("localhost", "root", "root", "local_train_ticket_db");
if (!$conn) {
    echo "<script type='text/javascript'>alert('Database failed');</script>";
    die('Could not connect: ' . mysqli_connect_error());
}
if (isset($_POST['submit'])) {

    $ticket_number = $_POST['ticketNumber'];

    echo ("<script>console.log('ticketNumber: " . $ticket_number . "');</script>");



    $query = "SELECT * FROM tickets WHERE ticket_id = $ticket_number LIMIT 1;";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $update_query = "UPDATE tickets SET valid = '0' WHERE ticket_id = $ticket_number;";
        if (mysqli_query($conn, $update_query)) {
            $message = "Ticket validated successfully";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else{
            $message = "Failed to validate ticket";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
    else{
        $message = "Ticket not found";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate Ticket Form</title>
    
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .background-image {
        /* Replace 'image.jpg' with the path to your background image */
        background-image: url('img/bg.png');
        background-size: cover;
        background-position: center;
        height: 90vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-container {
        background-color: rgba(255, 255, 255, 0.8);
        height: 50vh;
        width: 500px;
        align-items: center;
        padding: 40px;
        border-radius: 8px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 10px;
    }

    label {
        display: block;
         text-align: start;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    button:active {
        background-color: #003d80;
    }
</style>

<body>
    <?php
    include('header.php');
    ?>
    <div class="background-image">
        <div class="form-container">
            <h2>Validate Ticket</h2>
            <form id="ticketForm" action="validate_ticket.php" method="post">
                <div class="form-group">
                    <label for="ticketNumber">Ticket Number:</label>
                    <input type="text" id="ticketNumber" name="ticketNumber" required>
                </div>
                <div class="form-group">
                    <button type="submit" id="submit" name="submit">Validate</button>
                </div>
            </form>
        </div>

    </div>

</body>

</html>