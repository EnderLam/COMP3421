<?php
include 'db_connect.php';

if (!isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = $_COOKIE['user_id'];

$sql = "SELECT id, username, display_name 
        FROM users 
        WHERE id='$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $display_name = $row['display_name'];
} else {
    echo "User not found!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    $check_password = mysqli_fetch_assoc($result);

    if (!password_verify($password, $check_password['password'])) {
        echo "Invalid password!";
    } else if ($new_password !== $confirm_password) {
        echo "Passwords do not match!";
    } else {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);

        $sql = "UPDATE users 
        SET password='$new_password' 
        WHERE id='$user'";

        if ($conn->query($sql) === TRUE) {
            echo "Password reset successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset password</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Reset password</h1>
        <form method="post" action="" enctype="multipart/form-data">
            Password: <input type="password" name="password" required><br>
            New password: <input type="password" name="new_password" required><br>
            Confirm Password: <input type="password" name="confirm_password" required><br>
            <input type="submit" value="Reset password">
            <a href = "edit_profile.php"><input type="button" value ="Back"></a> 
        </form>
    </div>
</body>
</html>