<?php
include 'db_connect.php';

if (!isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_COOKIE['user_id'];
    $post_id = $_POST['post_id'];
    $content = $_POST['comment_content'];
    echo $content;

    $sql = "INSERT INTO comments (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$content')";
    if ($conn->query($sql) === False) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

header("Location: post_detail.php?post_id=" . $post_id);
exit();
?>