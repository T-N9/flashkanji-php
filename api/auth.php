<?php
include "../config/connectDb.php";
include '../includes/headers.php';

if (isset($_POST["user_id"]) && isset($_POST["user_name"]) && isset($_POST["user_mail"])) {
    // Sanitize input to prevent SQL injection
    $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);
    $user_name = mysqli_real_escape_string($conn, $_POST["user_name"]);
    $user_mail = mysqli_real_escape_string($conn, $_POST["user_mail"]);

    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$user_mail'";
    $checkResult = $conn->query($checkEmailQuery);

    if ($checkResult->num_rows > 0) {
        // Email already exists, fetch and return user information
        $existingUser = $checkResult->fetch_assoc();
        echo json_encode($existingUser);
    } else {
        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (user_id, display_name, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_id, $user_name, $user_mail);
        if ($stmt->execute()) {
            echo "Record added successfully";
        } else {
            // Log the error and display a user-friendly message
            error_log("Error adding record: " . $stmt->error);
            echo "Error adding record. Please try again later.";
        }

        $stmt->close();
    }
}

$conn->close();
?>