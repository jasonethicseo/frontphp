<?php
// 로그인 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $api_url = 'http://backend-server:8080/api/login';
    $data = array('email' => $email, 'passwd' => $password);

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);
    if ($response_data === "success") {
        // 로그인 성공
        $_SESSION['email'] = $email;
        header("Location: index.php");
    } else {
        echo "Login failed!";
    }
}
?>
