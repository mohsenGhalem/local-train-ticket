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

</style>

<body>
    <?php
    session_start();
    if (isset($_SESSION['user_info'])) {
        include("header.php");
    } else {
        include("loginheader.php");
    }
    ?>
    <div class="background-image">
        <div class="form-container">
            <h1>Welcome to Algeria Trains</h1>
            <h3>Have a safe journey with us</h3>

            <br /><br /><br />
            <?php
            if (isset($_SESSION['user_info']))
                echo '<h3 align="center"><a href="book_ticket.php">Book here</a></h3>';
            else
                echo '<h3 align="center"><a href="login.php">Please login before booking</a></h3>';
            ?>
        </div>

    </div>

</body>

</html>