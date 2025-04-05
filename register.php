<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $display_name = $_POST['display_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $username_exist = mysqli_fetch_assoc($result);

    $sql = "SELECT id FROM users WHERE display_name = '$display_name'";
    $result = mysqli_query($conn, $sql);
    $display_name_exist = mysqli_fetch_assoc($result);

    if ($username_exist) {
        echo "User already exist!";
    } else if ($display_name_exist) {
        echo "Someone already takes this name!";
    } else if ($password !== $confirm_password) {
        echo "Passwords do not match!";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, display_name, password) 
            VALUES ('$username', '$display_name', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
            header("Location: login.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="post" action="" enctype="multipart/form-data">
            User name: <input type="text" name="username" required><br>
            Display name: <input type="text" name="display_name" required><br>
            Password: <input type="password" name="password" required><br>
            Confirm Password: <input type="password" name="confirm_password" required><br>
            <input type="submit" value="Register">
            <a href = "index.php"><input type="button" value ="Return to Home page"></a> 
        </form>
    </div>
</body>
</html>