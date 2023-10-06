<?php

session_start();
if (!isset ($_SESSION["user"])){
    header("Location: login.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
    <h1>Welcome to Dashboard</h1>
    <h2>User Profile</h2>
    <?php
    require_once "database.php";
    $id = $_SESSION["user"];
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result);
    ?>
    <h3>Username : <?php echo $user["username"]; ?></h3>
    <p>Email: <?php echo $user["email"]; ?></p>
    <a href="logout.php" class="btn btn-warning">Logout</a>
</head>
<body>
    
</body>
</html>