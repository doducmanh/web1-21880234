<?php
$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST) && isset($_POST['g-token'])) {
    $secretKey = '6LdEZ28pAAAAAFP0TJdcLWCt5Y9V_2ghlpOOM6_5';
    $token = $_POST['g-token'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$token."&remoteip=".$ip;
    $request = file_get_contents($url);
    $response = json_decode($request); 

    if ($response->success && $response->action == 'submit' && $response->score >= 0.5) {
        header('HTTP/1.1 200 OK');
    } else {
        header('HTTP/1.1 401 Unauthorized');
    }
    
    echo json_encode($response);
    exit();
} 
?>