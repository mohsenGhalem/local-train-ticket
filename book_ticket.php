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

    $trains = $_POST['trains'];
    $currentDate = $_POST['dateForm'];
    $name = $_POST['name'];
    echo ("<script>console.log('DATE: " . $currentDate . "');</script>");
    echo ("<script>console.log('NAME: " . $name . "');</script>");
    echo ("<script>console.log('TRAIN: " . $trains . "');</script>");
    $sql = "SELECT * FROM journey WHERE train_id = $trains AND journey_day = '$currentDate' LIMIT 1;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {


        $fetched_data = $result->fetch_assoc();
        $journey_id = $fetched_data['journey_id'];
        $seats = $fetched_data['seats'];

        echo ("<script>console.log('journey_id: " . $journey_id . "');</script>");
        echo ("<script>console.log('seats: " . $seats . "');</script>");

        $checkQuery = "SELECT * from tickets WHERE journey_id = $journey_id";

        $row_count = mysqli_query($conn, $checkQuery);
        $booked_ticket = mysqli_num_rows($row_count);
        echo ("<script>console.log('booked_ticket: " . $booked_ticket . "');</script>");
        if ($booked_ticket < $seats) {
            $username = $_SESSION['user_info'];
            echo ("<script>console.log('username: " . $username . "');</script>");
            $query = "INSERT INTO `tickets` (`ticket_id`, `journey_id`, `passenger_name`, `purchase_date`, `valid`, `username`) VALUES (NULL, '$journey_id', '$name', CURRENT_TIMESTAMP, '1', '$username');";
            $inserted = $conn->query($query);
            if ($inserted) {

                $last_id = mysqli_insert_id($conn);
                echo ("<script>console.log('lastId: " . $last_id . "');</script>");
                $qurey_time = "SELECT * FROM trains WHERE train_id = $trains LIMIT 1;";
                $train_query = mysqli_query($conn, $qurey_time);
                $train_data = $train_query->fetch_assoc();
                $depare_time = $train_data['departure_time'];
                $arive_time = $train_data['arrival_time'];
                echo ("<script>console.log('departure_time: " . $depare_time . "');</script>");
                echo ("<script>console.log('arive_time: " . $arive_time . "');</script>");
                $message = 'Train ID : '.$last_id.'\nDepart Time : '.$depare_time.'\nArrive Time: '.$arive_time;
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else {
                $message = "Transaction failed";
            }
        } else {
            $message = "no availlable seats";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    } else {
        $message = 'No availlable trains on this date';
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

    }

    .form-group {
        margin-bottom: 10px;
    }

    label {
        text-align: start;
        display: block;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    select {
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

    #modal-overlay {
        width: 100%;
        height: 100vh;
        position: fixed;
        background: rgba(0, 0, 0, 0.7);
        display: none;
        align-items: center;
        justify-content: center;
    }

    #modal-overlay #modal {
        max-width: 650px;
        width: 100%;
        background: white;
        height: 250px;
        border-radius: 30px;
        border-color: black;
        line-height: 15px;


    }
</style>

<body>
    <?php
    include('header.php');
    ?>
    <div id="modal-overlay">
        <div id="modal" align="center">
        </div>
    </div>
    <div class="background-image">
        <div class="form-container">
            <h2>Book Ticket</h2>
            <form id="journeyform" action="book_ticket.php" method="post">
                <div class="form-group">
                    <label>Passenger name</label>
                    <input type="text" id="name" name="name" required />
                </div>
                <div class="form-group">
                    <label>Choose Date</label>
                    <input type="date" id="dateForm" name="dateForm" value="<?php echo date('Y-m-d'); ?>" required />
                </div>
                <div class="form-group">
                    <label>Choose Date</label>
                    <select id="trains" name="trains" required>
                        <option selected disabled>Select trains here</option>
                        <option value="1">Tlemcen - Oran</option>
                        <option value="2">Oran - Oued Tlilat</option>
                        <option value="3">Oran - Chelf</option>
                        <option value="4">Relizane - Blida</option>
                        <option value="5">Oran - Algiers</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" id="submit" name="submit">Book Ticket</button>
                </div>
            </form>
        </div>

    </div>

</body>

</html>