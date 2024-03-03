<?php
include "../config/connectDb.php";
include '../includes/headers.php';
include '../includes/routeValues.php';

function getData($sql)
{
    global $conn;
    $result = $conn->query($sql);

    if ($result === false) {
        return [];
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}

if ($is_user_id_get && $is_item_type_get && $is_forFavourite) {

    if ($item_type_get === 'kanji') {
        $sql = "SELECT k.id, k.kanji_character, k.onyomi, k.kunyomi, k.meaning
        FROM kanji k
        JOIN user_practice up ON up.item_id = k.id
        WHERE up.isFavourite = '1' AND up.user_id='$user_id_get' AND up.item_type='kanji'";
    } else {
        $sql = "SELECT j.id, j.jukugo_char, j.hiragana, j.english_meaning
    FROM jukugo j
    JOIN user_practice up ON up.item_id = j.id
    WHERE up.isFavourite = '1' AND up.user_id='$user_id_get' AND up.item_type='jukugo'";
    }

    $data = getData($sql);
    echo json_encode($data);

} elseif ($is_user_id_get && $is_item_type_get && $is_forTarget) {

    if ($item_type_get === 'kanji') {
        $sql = "SELECT k.id, k.kanji_character, k.onyomi, k.kunyomi, k.meaning
        FROM kanji k
        JOIN user_practice up ON up.item_id = k.id
        WHERE up.practice_status = 'need_more' AND up.user_id='$user_id_get' AND up.item_type='kanji'";
    } else {
        $sql = "SELECT j.id, j.jukugo_char, j.hiragana, j.english_meaning
    FROM jukugo j
    JOIN user_practice up ON up.item_id = j.id
    WHERE up.practice_status = 'need_more' AND up.user_id='$user_id_get' AND up.item_type='jukugo'";
    }

    $data = getData($sql);
    echo json_encode($data);

} elseif ($is_user_id_get && $is_item_type_get) {

    $sql = "SELECT * FROM user_practice
    WHERE user_id='$user_id_get' AND item_type='$item_type_get'";

    $data = getData($sql);
    echo json_encode($data);
}

if ($is_user_id_post && $is_item_id && $is_item_type_post && $is_practice_status) {

    $sql = "INSERT INTO user_practice(user_id, item_id,item_type, practice_status) 
    VALUES('$user_id_post',$item_id, '$item_type_post','$practice_status') 
    ON DUPLICATE KEY UPDATE practice_status = VALUES(practice_status)";

    if ($conn->query($sql) === TRUE) {
        echo "Record added successfully";
    } else {
        echo "Error adding record: " . $conn->error;
    }
}

if ($is_user_id_post && $is_item_id && $is_item_type_post && $is_is_favourite) {

    $sql = "INSERT INTO user_practice(user_id, item_id,item_type, isFavourite) 
    VALUES('$user_id_post',$item_id, '$item_type_post','$is_favourite') 
    ON DUPLICATE KEY UPDATE isFavourite = VALUES(isFavourite)";

    if ($conn->query($sql) === TRUE) {
        echo "Record added successfully";
    } else {
        echo "Error adding record: " . $conn->error;
    }
}

$conn->close();
?>