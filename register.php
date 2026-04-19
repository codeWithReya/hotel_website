<?php
session_start();
include("connect.php");

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$dob = $_POST['dob'] ?? '';

if(empty($name) || empty($email) || empty($password) || empty($dob)){
    echo "empty";
    exit();
}

// check email exists
$stmt = $conn->prepare("SELECT user_id FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    echo "exists";
    exit();
}

// insert user
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users(name,email,password,dob) VALUES(?,?,?,?)");
$stmt->bind_param("ssss", $name, $email, $hashedPassword, $dob);

if($stmt->execute()){

    // session create
    $_SESSION['user'] = [
        "id" => $stmt->insert_id,
        "name" => $name,
        "email" => $email,
        "dob" => $dob
    ];

    echo "success";

} else {
    echo "error";
}
?>