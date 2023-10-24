<?php
include '../config/connectDb.php';
include '../includes/headers.php';
include '../includes/routeValues.php';

/* Fetch All Kanji Data */
$sql = "SELECT * FROM kanji";
$result = $conn->query($sql);

$allKanjiData = array();
while ($row = $result->fetch_assoc()) {
    $allKanjiData[] = $row;
}

// Get random Kanji
function getRandomKanji($count)
{
    global $allKanjiData;

    $randomKanji = [];

    if (1 < $count && $count <= count($allKanjiData)) {
        // Get a random sample of Kanji from the data
        $randomKeys = array_rand($allKanjiData, $count);

        foreach ($randomKeys as $key) {
            $randomKanji[] = $allKanjiData[$key];
        }
    } elseif ($count === 1) {
        $randNo = rand(0, count($allKanjiData));

        $randomKanji = $allKanjiData[$randNo];
    } elseif ($count === 0 || $count > count($allKanjiData)) {
        $randomKanji = $allKanjiData;
        shuffle($randomKanji);
    }


    return $randomKanji;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($isCharacterIn) {
        /* Fetch Kanji Data by limits */
        $sql = "SELECT * FROM kanji WHERE id =$characterValue ";
        $result = $conn->query($sql);

        $characterData = array();
        while ($row = $result->fetch_assoc()) {
            $characterData[] = $row;
        }
        echo json_encode($characterData);
    } else if ($isRandIn) {
        $count = $randValue;

        // Return random Kanji
        $randomKanji = getRandomKanji($count);

        echo json_encode($randomKanji);

    } else if ($isLimitIn) {
        /* Fetch Kanji Data by limits */
        $sql = "SELECT * FROM kanji ORDER BY id LIMIT $limitValue OFFSET $fromValue ";
        $result = $conn->query($sql);

        $limitedKanjiData = array();
        while ($row = $result->fetch_assoc()) {
            $limitedKanjiData[] = $row;
        }
        echo json_encode($limitedKanjiData);

    } else if ($isChapterIn) {
        /* Fetch Kanji Data by Chapters */
        $sql = "SELECT * FROM kanji WHERE chapter = $chapterValue";
        $result = $conn->query($sql);

        $chapterKanjiData = array();
        while ($row = $result->fetch_assoc()) {
            $chapterKanjiData[] = $row;
        }
        echo json_encode($chapterKanjiData);
    } else {
        echo json_encode($allKanjiData);
    }


} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}



$conn->close();

?>