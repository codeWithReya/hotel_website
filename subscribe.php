<?php
include 'connect.php';

header('Content-Type: application/json');

$fullName = trim($_POST['fullName'] ?? 'Guest User');
$email = trim($_POST['email'] ?? '');
$subscription = $_POST['subscription'] ?? 'basic';

if(empty($email)){
    echo json_encode(["status"=>"empty"]);
    exit();
}

$validPlans = ['basic', 'premium', 'vip'];
if(!in_array($subscription, $validPlans)){
    $subscription = 'basic';
}

// Check duplicate email
$check = $conn->prepare("SELECT id FROM user_subscription WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if($check->num_rows > 0){
    echo json_encode(["status"=>"exists"]);
    exit();
}

$stmt = $conn->prepare("INSERT INTO user_subscription (fullName, email, subscription) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $fullName, $email, $subscription);

if($stmt->execute()){
    echo json_encode([
        "status"=>"success",
        "plan"=>$subscription   
    ]);
}else{
    echo json_encode([
        "status"=>"error",
        "message"=>$stmt->error
    ]);
}

$stmt->close();
$check->close();
$conn->close();
?>