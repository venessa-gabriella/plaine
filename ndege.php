<?php
$alert = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $from     = $_POST['from_city'];
    $to       = $_POST['to_city'];
    $date     = $_POST['departure_date'];
    $pass     = $_POST['passengers'];

    $alert = "Booking Confirmed!\\n\\nName: $fullname\\nFrom: $from\\nTo: $to\\nDate: $date\\nPassengers: $pass";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Flight Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #10b981 0%, #ec4899 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        form {
            background: #ffffff;
            padding: 35px 30px;
            width: 100%;
            max-width: 420px;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(236, 72, 153, 0.35);
            border-top: 6px solid #10b981;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            background: linear-gradient(135deg, #10b981, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 25px;
            font-size: 24px;
            letter-spacing: 0.5px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #10b981;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input, select {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 18px;
            border: 2px solid #d1fae5;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: #111827;
            background: #f0fdf4;
            transition: all 0.25s ease;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #ec4899;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.15);
        }

        input:hover, select:hover {
            border-color: #ec4899;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981, #ec4899);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.25s ease;
            margin-top: 8px;
            box-shadow: 0 6px 15px rgba(236, 72, 153, 0.4);
        }

        button:hover {
            background: linear-gradient(135deg, #059669, #db2777);
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(236, 72, 153, 0.55);
        }

        button:active {
            transform: translateY(0);
            box-shadow: 0 4px 10px rgba(236, 72, 153, 0.35);
        }

        /* Mobile tweak */
        @media (max-width: 480px) {
            form { padding: 25px 20px; }
            h2 { font-size: 20px; }
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <h2>✈️ Book Your Flight</h2>

    <label>Full Name</label>
    <input type="text" name="fullname" placeholder="e.g. John Doe" required>

    <label>Email</label>
    <input type="email" name="email" placeholder="you@example.com" required>

    <label>From</label>
    <input type="text" name="from_city" placeholder="e.g. Nairobi" required>

    <label>To</label>
    <input type="text" name="to_city" placeholder="e.g. Mombasa" required>

    <label>Departure Date</label>
    <input type="date" name="departure_date" required>

    <label>Passengers</label>
    <select name="passengers">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
    </select>

    <button type="submit">Book Flight</button>
</form>

<?php if ($alert != ""): ?>
<script>
    alert("<?php echo $alert; ?>");
</script>
<?php endif; ?>

</body>
</html>