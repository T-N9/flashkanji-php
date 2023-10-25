<?php
include "../config/connectDb.php";

$id = $_POST["id"];
$updates = [];

if (isset($_POST["character"])) {
    $kanji_character = $_POST["character"];
    $updates[] = "kanji_character='$kanji_character'";
}

if (isset($_POST["onyomi"])) {
    $onyomi = $_POST["onyomi"];
    $updates[] = "onyomi='$onyomi'";
}

if (isset($_POST["kunyomi"])) {
    $kunyomi = $_POST["kunyomi"];
    $updates[] = "kunyomi='$kunyomi'";
}

if (isset($_POST["meaning"])) {
    $meaning = $_POST["meaning"];
    $updates[] = "meaning='$meaning'";
}

if (isset($_POST["level"])) {
    $level = $_POST["level"];
    $updates[] = "level='$level'";
}

if (isset($_POST["chapter"])) {
    $chapter = $_POST["chapter"];
    $updates[] = "chapter='$chapter'";
}

if (!empty($updates)) {
    $updateString = implode(',', $updates);

    $sql = "UPDATE kanji SET $updateString WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "No fields provided for update.";
}

$conn->close();
?>