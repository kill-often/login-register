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
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST["submit"])){
            $userName = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();
            if(empty($userName) OR empty($email) OR empty($password) OR empty($passwordRepeat)){
                array_push($errors, "All fieldS are required");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email is not valid");
        }
        if(strlen($password)<8){
            array_push($errors, "Password must be at atleast 8 characters long");
        }
        if($password!==$passwordRepeat){
            array_push($errors, "Password does not mtach");
        }
        require_once "database.php";
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $_result = mysqli_query($conn,$sql);
        $rowCount = mysqli_num_rows($_result);
        if($rowCount>0){
            array_push($errors, "Email alread exists!");
        }
if(count($errors)>0){
    foreach($errors as $error){
        echo "<div class='alert alert-danger'>$error</div>";

    }
}else{
    //  We will insert the data intor database
    
    $sql = "INSERT INTO users (	username,email,	password) VALUES (?, ?, ? )";
    $stmt= mysqli_stmt_init($conn);
    $prepareStmt=  mysqli_stmt_prepare($stmt, $sql);
    if($prepareStmt){
        mysqli_stmt_bind_param($stmt, "sss", $userName, $email, $passwordHash);
        mysqli_stmt_execute($stmt);
        echo "<div class= 'alert alert-success'>You are registered successfully.<div>";
    }else{
        die("Something went wrong");
    }
}


    }
        ?>
<form action="registration.php" method="post">
    <div class="form-group">
    <input type="text" class="form-control" name="username" placeholder="User Name:">
    </div>
    <div class="form-group">
    <input type="email" class="form-control" name="email" placeholder="Email:">
    </div>
    <div class="form-group">
    <input type="password" class="form-control" name="password" placeholder="Password:">
    </div>
    <div class="form-group">
    <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
    </div>
    <div class=" 1`">
    <input type="submit" class="btn btn-primary" value="Register" name="submit">
    </div>   
</form>
    </div>
    <div><p>Already Registered <a href="login.php">Login Here</a></p></div>
</div>
</div>
</body>
</html>