<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 验证CAPTCHA
    $secretKey = "your-secret-key";
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
    $response = file_get_contents($url);
    $response = json_decode($response);

    if ($response->success) {
        // 收集表单数据
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        // 设置接收邮件的电子邮件地址
        $to = "your-email@example.com"; // 替换为您的电子邮件地址
        $subject = "新的联系请求";
        $messageBody = "姓名: " . $name . "\n电子邮件: " . $email . "\n消息内容: " . $message;
        $headers = "From: no-reply@example.com"; // 替换为您的网站域名

        // 发送邮件
        if (mail($to, $subject, $messageBody, $headers)) {
            echo "邮件发送成功。";
        } else {
            echo "邮件发送失败。";
        }
    } else {
        echo "CAPTCHA验证失败，请重试。";
    }
}
?>