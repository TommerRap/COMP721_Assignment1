<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Status Posting System</title>
</head>

<body>
    <div class="container">

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

        $tableCheck = "SHOW TABLES LIKE 'status'";
        $result = mysqli_query($connect, $tableCheck);
        if (mysqli_num_rows($result) == 1) {

            $query = "DROP TABLE status;";

            if (mysqli_query($connect, $query)) {
                echo "<p>Database reset successfully!</p>"; //Success
            } else {
                echo "<p>Failed to reset database!</p>"; //Error
            }
        } else {
            echo "<p>Table does not exist. Please create a post.</p>"; //Not Found
        }
        mysqli_close($connect);
        ?>
        <div class="ops">
            <a href="poststatusform.php" class="flex-item btn">Post Now</a>
            <a href="index.html" class="flex-item btn">Return Home</a>
        </div>
    </div>

</body>

</html>