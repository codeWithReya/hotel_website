<?php
include 'connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['feedback']) && !empty(trim($_POST['feedback']))) {

        $feedback = $_POST['feedback'];

        $stmt = $conn->prepare("INSERT INTO user_feedback (feedback_text, created_at) VALUES (?, NOW())");
        $stmt->bind_param("s", $feedback);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "feedback" => $feedback
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => $stmt->error
            ]);
        }

        $stmt->close();

    } else {
        echo json_encode([
            "status" => "empty",
            "message" => "Feedback cannot be empty"
        ]);
    }

} else {

    $result = $conn->query("SELECT id, feedback_text, created_at FROM user_feedback ORDER BY id DESC");

    $feedbacks = [];

    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = [
            "id" => $row['id'],
            "feedback" => $row['feedback_text'],
            "created_at" => $row['created_at']
        ];
    }

    echo json_encode($feedbacks);
}
?>