<!DOCTYPE html>
<html>
<head>
    <title>Ticket</title>
    <style>
        /* Add CSS styles for your ticket here */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .ticket {
            border: 2px solid #000;
            padding: 10px;
            width: 200px;
        }

        .ticket-info {
            margin-bottom: 10px;
        }

        .ticket-info label {
            font-weight: bold;
        }

        .ticket-qrcode {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-info">
            <label>Train ID:</label> <?php echo $train_id; ?>
        </div>
        <div class="ticket-info">
            <label>Journey Day:</label> <?php echo $journey_day; ?>
        </div>
        <!-- Add other ticket information here -->
        <div class="ticket-qrcode">
            <!-- You can add a QR code here if you have the data for it -->
            <!-- Example: <img src="qrcode.php?data=<?php echo $qr_data; ?>" alt="QR Code"> -->
        </div>
    </div>
</body>
</html>
