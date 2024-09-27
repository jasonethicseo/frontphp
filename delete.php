<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // API로 할 일 삭제 요청
    $api_url = "http://backend-server:8080/api/todos/$id";
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

    $response = curl_exec($ch);
    curl_close($ch);

    // 삭제 후 목록으로 리다이렉트
    header('Location: index.php');
}
?>
