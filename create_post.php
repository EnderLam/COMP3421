<?php
include 'db_connect.php';

if (!isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_COOKIE['user_id'];

$sql = "SELECT role, display_name FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $is_admin = ($row['role'] == 'admin');
    $display_name = $row['display_name'];
} else {
    echo "User not found!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_COOKIE['user_id'];
    $title = $_POST['title'];
    $content = ($_POST['content']);

    $sql = "INSERT INTO posts (user_id, title, content) VALUES ('$user_id', '$title', '$content')";
    if ($conn->query($sql) === True) {
        header("Location: post.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    header("Location: post.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Post</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <nav>
         <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="post.php">Post</a></li>
            <li><a href="create_post.php">Create New Post</a></li>
            <?php if ($is_admin): ?>
                <li><a href="manage_post.php">Manage Posts</a></li>
            <?php endif; ?>
            <li><a href="edit_profile.php">Edit Profile</a></li>
            <li><a href="logout.php">Logout (<?php echo $display_name; ?>)</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Create New Post</h1>
        <form method="POST">
            <textarea name="title" class="post_title" placeholder="Give a title" required></textarea>
            <textarea name="content" class="post" placeholder="Start your post here" rows="10" required></textarea>
            <button type="submit">Publish Post</button>
        </form>
    </div>
</body>
</html>