<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // API를 통해 할 일 수정 요청
    $api_url = "http://backend-server:8080/api/todos/$id";
    $data = array(
        'title' => $title,
        'content' => $content,
        'user' => $_SESSION['username']
    );

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);

    if ($response_data['status'] == 'success') {
        echo "<script>alert('Todo updated successfully');</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    } else {
        echo "<script>alert('Failed to update todo');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Todo</title>
</head>
<body>
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // 기존 할 일 데이터 조회
        $api_url = "http://backend-server:8080/api/todos/$id";
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $todo = json_decode($response, true);
    ?>
        <h1>Edit Todo</h1>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?= $todo['title'] ?>" required>
            <br><br>
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="4" cols="50" required><?= $todo['content'] ?></textarea>
            <br><br>
            <input type="submit" value="Submit">
        </form>
    <?php
    }
    ?>
</body>
</html>
