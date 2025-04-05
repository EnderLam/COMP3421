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

$sql = "SELECT posts.*, users.display_name 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY created_at DESC";
$result_of_posts = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
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
        <h1>Blog Posts</h1>
        
        <?php if ($result_of_posts->num_rows > 0): ?>
            <?php while ($post = $result_of_posts->fetch_assoc()): ?>
                <div class="post-summary">
                    <p class="post_meta">
                        <?= $post['display_name'] . ": " . $post['created_at'] ?>
                    </p>
                    <h2><a class="post_detail" href="post_detail.php?post_id=<?= $post['post_id'] ?>"><?= $post['title'] ?></a></h2>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>
</body>
</html>