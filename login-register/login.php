<?php

session_start();
if (isset ($_SESSION["user"])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
    if(isset($_POST["login"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        require_once "database.php";
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result);
       
        
     
        
        if($user){
            if(password_verify($password, $user["password"])){
                $id= $user['id'];
                session_start();
                $_SESSION["user"] = $id;
                header("Location: index.php");
                die();
            
            }else{
                echo "<div class='alert alert-danger'>Password does not match</div>";
            }
        }else{
            echo "<div class='alert alert-danger'>Email does not match</div>";
        }
    }
        ?>
        <form action="login.php" method="post">
        <div class="group">
            <input type="email" name="email" class="form-control" placeholder="Enter Email:">
        </div>
        <div class="group">
            <input type="password" name="password" class="form-control" placeholder="Enter Password:">
        </div>
        <div class="group">
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </div>
        </form>
        <div><p>Not registered yet <a href="registration.php">Registere Here</a></p></div>
    </div>
</body>
</html>