<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
</head>
<body>
    <?php
    if (isset($_SESSION['username'])) {
        echo "Welcome " . $_SESSION['username'];
    ?>
        <input type="button" value="Logout" onclick="location.href='logout.php'">
        <input type="button" value="Write" onclick="location.href='write.php'">
    <?php
    } else {
        echo "Please log in to view your todos.";
        exit();
    }
    ?>

    <h2>Your Todos</h2>
    <table border="1">
        <tr>
            <th>Todo ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Actions</th>
        </tr>
        <?php
        // API로 모든 할 일 조회
        $api_url = 'http://backend-server:8080/api/todos';
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $todos = json_decode($response, true);

        if ($todos) {
            foreach ($todos as $todo) {
        ?>
            <tr>
                <td><?= $todo['id'] ?></td>
                <td><?= $todo['title'] ?></td>
                <td><?= $todo['content'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $todo['id'] ?>">Edit</a> |
                    <a href="delete.php?id=<?= $todo['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='4'>No todos found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
