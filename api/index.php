<?php
include '../config/connectDb.php';
include '../includes/headers.php';
include '../includes/routeValues.php';

function fetchKanjiData($sql)
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

/* Fetch All Kanji Data */
$sql = "SELECT * FROM kanji";
$allKanjiData = fetchKanjiData($sql);

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
    if ($isShuffled && $isPageIn) {
        // Determine the current page
        $itemsPerPage = 10;
        $offset = ($pageValue - 1) * $itemsPerPage;

        // Select 10 items based on pagination
        $sql = "SELECT * FROM shuffled_kanji LIMIT $offset, $itemsPerPage";
        $shuffledData = fetchKanjiData($sql);

        echo json_encode($shuffledData);

    } else if ($isCharacterIn) {
        /* Fetch Character data by its ID */
        $sql = "SELECT * FROM kanji WHERE id =$characterValue ";
        $characterData = fetchKanjiData($sql);
        echo json_encode($characterData);
    } else if ($isRandIn) {
        $count = $randValue;
        // Return random Kanji
        $randomKanji = getRandomKanji($count);
        echo json_encode($randomKanji);
    } else if ($isLimitIn) {
        /* Fetch Kanji Data by limits */
        $sql = "SELECT * FROM kanji ORDER BY id LIMIT $limitValue OFFSET $fromValue ";
        $limitedKanjiData = fetchKanjiData($sql);
        echo json_encode($limitedKanjiData);

    } else if ($isChapterIn && $isLevelIn) {
        /* Fetch Kanji Data by Chapters and Levels */
        $sql = "SELECT * FROM kanji WHERE chapter = $chapterValue AND level = $levelValue";

        $chapterKanjiData = fetchKanjiData($sql);
        echo json_encode($chapterKanjiData);
    } else if ($isChaptersIn && $isLevelIn) {
        $sql = "SELECT * FROM kanji WHERE chapter IN ($chaptersValue) AND level = $levelValue";
        $chaptersKanjiData = fetchKanjiData($sql);
        echo json_encode($chaptersKanjiData);
    } else if ($isLevelIn) {
        /* Fetch Kanji Data only by Levels */
        $sql = "SELECT * FROM kanji WHERE level = $levelValue";

        $levelKanjiData = fetchKanjiData($sql);
        echo json_encode($levelKanjiData);
    } else if ($isSearchIn) {
        $sql = "SELECT * FROM kanji WHERE 
            kanji_character LIKE '%$searchValue%' OR 
            onyomi LIKE '%$searchValue%' OR 
            kunyomi LIKE '%$searchValue%' OR 
            meaning LIKE '%$searchValue%'";

        $searchKanjiData = fetchKanjiData($sql);
        echo json_encode($searchKanjiData);
    } else {
        echo json_encode($allKanjiData);
    }





} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}
$conn->close();
?>