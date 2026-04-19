<?php
include("connect.php");
header("Content-Type: application/json");

$email = $_POST['email'] ?? '';
$booking_id = $_POST['booking_id'] ?? '';
$pickup_time = $_POST['pickup_time'] ?? '';
$car_name = $_POST['car_name'] ?? '';

/* STEP 1: check booking_id exists */
$sql = "SELECT booking_id FROM bookings WHERE booking_id=?
        UNION
        SELECT booking_id FROM goa_bookings WHERE booking_id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $booking_id, $booking_id);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows == 0){
    echo json_encode([
        "status"=>"error",
        "message"=>"Invalid Booking ID"
    ]);
    exit;
}

/* STEP 2: AUTO GENERATE DRIVER */
$driver_names = ["Amit Sharma", "Rahul Verma", "Sanjay Singh", "Vikas Yadav", "Neeraj Kumar"];
$driver_name = $driver_names[array_rand($driver_names)];

$driver_phone = "98" . rand(10000000, 99999999);

/* STEP 3: INSERT INTO DB */
$sql2 = "INSERT INTO car_rentals 
(booking_id, email, car_name, pickup_time, driver_name, driver_phone, created_at)
VALUES (?, ?, ?, ?, ?, ?, NOW())";

$stmt2 = $conn->prepare($sql2);

if(!$stmt2){
    echo json_encode([
        "status"=>"error",
        "message"=>"Prepare failed: ".$conn->error
    ]);
    exit;
}

$stmt2->bind_param(
    "ssssss",
    $booking_id,
    $email,
    $car_name,
    $pickup_time,
    $driver_name,
    $driver_phone
);

if($stmt2->execute()){
    echo json_encode([
        "status"=>"success",
        "booking_id"=>$booking_id,
        "email"=>$email,
        "car_name"=>$car_name,
        "pickup_time"=>$pickup_time,
        "driver_name"=>$driver_name,
        "driver_phone"=>$driver_phone
    ]);
} else {
    echo json_encode([
        "status"=>"error",
        "message"=>"Insert failed: ".$stmt2->error
    ]);
}
?>