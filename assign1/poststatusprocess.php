<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Status Posting System</title>
</head>

<body>
    <div class="container content">

        <?php
        // Database connection
        $dbConfig = include('dbconfig.php');
        $host = $dbConfig['host'];
        $user = $dbConfig['user'];
        $pass = $dbConfig['pass'];
        $dbname = $dbConfig['dbname'];
        $connect = mysqli_connect($host, $user, $pass, $dbname);

        // Check connection
        if (!$connect) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        echo '<div class="content">';

        // Check if table exists, if not create
        $tableCheck = "SHOW TABLES LIKE 'status'";
        $result = mysqli_query($connect, $tableCheck);
        if (mysqli_num_rows($result) == 0) {
            $createTable = "CREATE TABLE status (
        StatusCode VARCHAR(5) PRIMARY KEY,
        Status VARCHAR(255) NOT NULL,
        Share VARCHAR(20) NOT NULL,
        DatePosted DATE NOT NULL,
        Permission VARCHAR(255)
    )";
            mysqli_query($connect, $createTable);
        }

        // Validate inputs
        $stcode = trim($_POST['stcode']);
        $status = trim($_POST['st']);
        $share = $_POST['share'];
        $date = $_POST['date'];
        $permission = isset($_POST['permission']) ? implode(", ", $_POST['permission']) : "";

        $valid = true;

        //ST Code validation
        if (empty($stcode) || !preg_match("/^S\d{4}$/", $stcode)) { //!! REGIX IS AI GENERATED.
            echo "<h1 class=\"warning\">Wrong format! Status code must start with 'S' followed by four digits, like 'S0001'.</h1>";
            $valid = false;
        }

        //Status Msgvalidation
        if (empty($status) || !preg_match("/^[a-zA-Z0-9,.!? ]+\$/", $status)) { //!! REGIX IS AI GENERATED.
            echo "<h1 class=\"warning\">Your status is in a wrong format! It can only contain alphanumericals and , . ! ?</h1>";
            $valid = false;
        }

        //Date validation
        try {
            $dateParts = explode('/', $date);
            if (count($dateParts) != 3 || !checkdate($dateParts[1], $dateParts[0], $dateParts[2])) {
                echo "<h1 class=\"warning\">Date format is wrong. Please use dd/mm/yyyy format.</h1>";
                $valid = false;
            }
        } catch (Error $e) {
            echo "<h1 class=\"warning\">Date format is wrong. Please use dd/mm/yyyy format.</h1>";
            $valid = false;
        }

        // Check unique status code
        $stcodeEscaped = mysqli_real_escape_string($connect, $stcode);
        $checkUnique = mysqli_query($connect, "SELECT * FROM status WHERE StatusCode = '$stcodeEscaped'");
        if (mysqli_num_rows($checkUnique) > 0) {
            echo "<h1 class=\"warning\">The status code already exists. Please try another one!</h1>";
            $valid = false;
        }

        if ($valid) {
            // Insert into table
            $dateFormatted = $dateParts[2] . "-" . $dateParts[1] . "-" . $dateParts[0];
            $statusEscaped = mysqli_real_escape_string($connect, $status);
            $permissionEscaped = mysqli_real_escape_string($connect, $permission);
            $insert = "INSERT INTO status (StatusCode, Status, Share, DatePosted, Permission) VALUES ('$stcodeEscaped', '$statusEscaped', '$share', '$dateFormatted', '$permissionEscaped')";
            if (mysqli_query($connect, $insert)) {
                echo "<h1> The status has been posted successfully!</h1>";
            } else {
                echo "<h1 class=\"warning\">Error occurred while saving the status!</h1>";
            }
        }
        mysqli_close($connect);


        ?>
        <div class="ops">
            <a href="poststatusform.php" class="flex-item btn">Post Another</a>
            <a href="index.html" class="flex-item btn">Return Home</a>
        </div>
    </div>

</body>

</html>