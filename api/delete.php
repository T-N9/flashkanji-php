<?php
include "../config/connectDb.php";

$id = $_POST["id"];

$sql = "DELETE FROM kanji WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>