<?php
include("connect.php");
session_start();

header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// login check
if(!isset($_SESSION['user']['email'])){
    echo json_encode([
        "status" => "not_logged_in",
        "debug" => "Session email not set"
    ]);
    exit;
}

$email = $_SESSION['user']['email'];
$data = [];

// TABLE 1 - bookings 
$stmt1 = $conn->prepare("SELECT * FROM bookings WHERE LOWER(email)=LOWER(?) ORDER BY id DESC");
$stmt1->bind_param("s", $email);
$stmt1->execute();
$result1 = $stmt1->get_result();

if($result1 && $result1->num_rows > 0){
    while($row = $result1->fetch_assoc()){
        $row['source'] = "General Booking";
        $data[] = $row;
    }
}

// TABLE 2 - goa_bookings 
$stmt2 = $conn->prepare("SELECT * FROM goa_bookings WHERE LOWER(email)=LOWER(?) ORDER BY id DESC");
$stmt2->bind_param("s", $email);
$stmt2->execute();
$result2 = $stmt2->get_result();

if($result2 && $result2->num_rows > 0){
    while($row = $result2->fetch_assoc()){
        $row['source'] = "Goa Booking";
        $data[] = $row;
    }
}

if(empty($data)){
    echo json_encode([
        "status" => "no_data",
        "debug" => "No bookings found for email: $email"
    ]);
    exit;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);
?>