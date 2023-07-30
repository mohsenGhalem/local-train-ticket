<?php
session_start();
if (isset($_POST['submit'])) {
    $conn = mysqli_connect("localhost", "root", "root", "local_train_ticket_db");
    if (!$conn) {
        echo "<script type='text/javascript'>alert('Database failed');</script>";
        die('Could not connect: ' . mysqli_connect_error());
    }
    $email = $_POST['username'];
    $pw = $_POST['pw'];
    $sql = "SELECT * FROM users WHERE username = '$email' AND password = '$pw';";
    $sql_result = mysqli_query($conn, $sql) or die('request "Could not execute SQL query" ' . $sql);
    $user = mysqli_fetch_assoc($sql_result);
    if (!empty($user)) {
        $_SESSION['user_info'] = $user['username'];
        $message = 'Logged in successfully';
        echo "<script type='text/javascript'>location.href='index.php'</script>";
    } else {
        $message = 'Wrong username or password.';
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>
<script type="text/javascript">
    function validate() {
        var username = document.getElementById("username");
        var pw = document.getElementById("pw");
        if (username.length == 0 || username.length < 4) {
            alert("Enter valid username");
            username.focus();
            return false;
        }
        if (pw.value.length < 8) {
            alert("Password consists of atleast 8 characters");
            pw.focus();
            return false;
        }
        return true;
    }
</script>
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
    <?php include("loginheader.php") ?>
    <div class="background-image">
        <div class="form-container">
            <form id="login" action="login.php" onsubmit="return validate()" method="post" name="login">


                <h2>Login to Dashboard</h2>
                <form id="ticketForm" action="validate_ticket.php" method="post">
                    <div class="form-group">
                        <label for="ticketNumber">Username :</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="ticketNumber">Password :</label>
                        <input type="password" id="pw" name="pw" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="submit" name="submit">Login</button>
                    </div>
                </form>
            </form>
        </div>
    </div>
</body>

</html>