<?php
include("connect.php");
header("Content-Type: application/json");

// Random user_id generate
$booking_id = "UID" . rand(10000,99999);

// Data get
$name     = $_POST['name'] ?? '';
$phone    = $_POST['phone'] ?? '';
$email    = $_POST['email'] ?? '';
$request  = $_POST['request'] ?? '';
$checkin  = $_POST['checkin'] ?? '';
$checkout = $_POST['checkout'] ?? '';
$state    = $_POST['state'] ?? '';
$city     = $_POST['city'] ?? '';

// Insert query
$sql = "INSERT INTO goa_bookings 
(booking_id, name, phone, email, request, checkin, checkout, state, city)
VALUES ('$booking_id','$name','$phone','$email','$request','$checkin','$checkout','$state','$city')";

if($conn->query($sql) === TRUE){
    echo json_encode([
        "status"   => "success",
        "booking_id"  => $booking_id,
        "name"     => $name,
        "phone"    => $phone,
        "email"    => $email,
        "request"  => $request,
        "checkin"  => $checkin,
        "checkout" => $checkout,
        "state"    => $state,
        "city"     => $city
    ]);
} else {
    echo json_encode([
        "status"  => "error",
        "message" => $conn->error   
    ]);
}
?>