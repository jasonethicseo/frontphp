<?php
$username = $_POST['username'];
$password = $_POST['password'];

// Java 백엔드 URL 설정
$javaBackendUrl = 'http://internal-ec2-back-alb-sjy-551393573.us-west-2.elb.amazonaws.com:8080/authenticate'; // 'your-app-name'을 실제 애플리케이션 이름으로 변경하세요.

// 데이터 배열 생성
$data = array('username' => $username, 'password' => $password);

// cURL을 사용하여 POST 요청 전송
$ch = curl_init($javaBackendUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 응답 받기
$result = curl_exec($ch);
curl_close($ch);

// 응답 처리
$response = json_decode($result, true);

if ($response['status'] == 'success') {
    echo '로그인 성공!';
} else {
    echo '로그인 실패: ' . $response['message'];
}
?>
