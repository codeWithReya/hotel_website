<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // 🔹 SAME SIMPLE USER ID (as you wanted)
    $booking_id = "UID" . rand(10000,99999);

    // ✅ Inputs sanitize
    $name     = htmlspecialchars(trim($_POST['name'] ?? ''));
    $phone    = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $email    = htmlspecialchars(trim($_POST['email'] ?? ''));
    $request  = htmlspecialchars(trim($_POST['request'] ?? ''));
    $checkin  = $_POST['checkin'] ?? '';
    $checkout = $_POST['checkout'] ?? '';
    $country  = htmlspecialchars(trim($_POST['country'] ?? ''));
    $state    = htmlspecialchars(trim($_POST['state'] ?? ''));
    $accommodation = htmlspecialchars(trim($_POST['accommodation'] ?? 'Apartment'));

    if (!$name || !$phone || !$email || !$checkin || !$checkout) {
        echo json_encode([
            "status" => "empty",
            "message" => "Please fill all required fields"
        ]);
        exit();
    }

    if ($checkout <= $checkin) {
        echo json_encode([
            "status" => "invalid_date",
            "message" => "Checkout must be after checkin"
        ]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO bookings 
        (booking_id, name, phone, email, request, checkin, checkout, country, state, accommodation)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // 🔥 ALL STRING TYPES
    $stmt->bind_param(
        "ssssssssss",
        $booking_id,
        $name,
        $phone,
        $email,
        $request,
        $checkin,
        $checkout,
        $country,
        $state,
        $accommodation
    );

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "booking_id" => $booking_id,
            "name" => $name,
            "phone" => $phone,
            "email" => $email,
            "request" => $request,
            "checkin" => $checkin,
            "checkout" => $checkout,
            "country" => $country,
            "state" => $state,
            "accommodation" => $accommodation
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => $stmt->error
        ]);
    }

    $stmt->close();
    $conn->close();
}
?>