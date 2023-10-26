<?php
include "../config/connectDb.php";

$id = $_POST["id"];
$updates = [];

if (isset($_POST["kanji_character"])) {
    $kanji_character = $_POST["kanji_character"];
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

if (count($updates) === 6) {


    $sql = "INSERT INTO kanji ( kanji_character, onyomi, kunyomi, meaning, chapter, level) VALUES
    ('$kanji_character',' $onyomi', '$kunyomi', '$meaning', $chapter, $level)";

    echo $sql;

    if ($conn->query($sql) === TRUE) {
        echo "Record added successfully";
    } else {
        echo "Error adding record: " . $conn->error;
    }
} else {
    var_dump($updates);
}

$conn->close();
?>