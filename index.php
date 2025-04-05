<?php
session_start(); 
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Tutor Matching System</title>
    <link rel="stylesheet" type="text/css" href="indexstyle.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php
            if (isset($_COOKIE['user_id'])) {
                $user_id = $_COOKIE['user_id'];

                $sql = "SELECT role, display_name FROM users WHERE id = '$user_id'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $is_admin = ($row['role'] == 'admin');
                    $display_name = $row['display_name'];
                }  else {
                    header("Location: logout.php");
                }

                echo '<li><a href="post.php">Post</a></li>';
                echo '<li><a href="create_post.php">Create New Post</a></li>';
                if ($is_admin):
                    echo '<li><a href="manage_post.php">Manage Posts</a></li>';
                endif;
                
                echo '<li><a href="edit_profile.php">Edit Profile</a></li>';
                echo '<li><a href="logout.php">Logout (' . $display_name . ')</a></li>';
                
            } else {
                echo '<li><a href="login.php">Login</a></li>';
                echo '<li><a href="register.php">Register</a></li>';
            }
            ?>
        </ul>
    </nav>

    <div class="container">
        <header>
            <h1>Welcome to the Online blogging platform</h1>
            <p>Share the information to everyone!</p>
        </header>

        <?php if (!isset($_COOKIE['user_id'])): ?>
            <section class="auth-prompt">
                <h2>Get Started</h2>
                <p>Join our platform to create or find a post.</p>
                <div class="auth-buttons">
                    <a href="login.php" class="btn">Login</a>
                    <a href="register.php" class="btn">Register</a>
                </div>
            </section>
        <?php endif; ?>
    </div>
</body>
</html>