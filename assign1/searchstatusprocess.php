<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Status</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

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
    echo '<div class="container content">';
    $search = trim($_GET['search']);


    if (empty($search)) {
        echo "<h1 class=\"warning\">Please enter a search term.</h1>";
    }
    // Check if table exists, only process if it does.
    $tableCheck = "SHOW TABLES LIKE 'status'";
    $result = mysqli_query($connect, $tableCheck);
    if (mysqli_num_rows($result) == 1) {
        // Search for status
        $searchEscaped = mysqli_real_escape_string($connect, $search);
        $query = "SELECT * FROM status WHERE Status LIKE '%$searchEscaped%' OR StatusCode = '$searchEscaped'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) == 0) {
            echo "<p>Status not found. Please try a different keyword.</p>";
            echo " <div class=\"ops\">";
            echo " <a href=\"searchstatusform.html\" class=\"btn\">Search Again</a>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<h2>Status Information</h2>";
                echo "<p>Status: " . htmlspecialchars($row['Status']) . "</p>";
                echo "<p>Status Code: " . htmlspecialchars($row['StatusCode']) . "</p>";
                echo "<p>Share: " . htmlspecialchars($row['Share']) . "</p>";
                echo "<p>Date Posted: " . date('d/m/Y', strtotime($row['DatePosted'])) . "</p>";
                echo "<p class=\"mb-2\">Permission: ";
                $permissions = explode(',', $row['Permission']);
                //iterate through the permissions returned, cover with span to apply css
                foreach ($permissions as $perm) {
                    $perm = trim($perm);
                    echo "<span class=\"permBox\">" . htmlspecialchars($perm) . "</span> ";
                }
                echo "</p>";
            }
            echo " <div class=\"ops\">";
        }
    } else {

        echo "<h1 class=\"warning\">No status found in the System. Please go to the post status page to post one.</h1>";
        echo " <div class=\"ops\">";
    }


    echo " <a href=\"index.html\" class=\"btn\">Return Home</a>";
    echo "</div>";
    ?>