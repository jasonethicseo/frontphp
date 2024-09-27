<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $username = $_SESSION['username'];  // 로그인된 사용자명

    // API로 새로운 할 일 등록
    $api_url = 'http://backend-server:8080/api/todos';
    $data = array(
        'title' => $title,
        'content' => $content,
        'user' => $username
    );

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);
    
    if ($response_data['status'] == 'success') {
        echo "<script>alert('Todo added successfully');</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    } else {
        echo "<script>alert('Failed to add todo');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Todo</title>
</head>
<body>
    <h1>Add Todo</h1>
    <form action="write.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br><br>
        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="4" cols="50" required></textarea>
        <br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
