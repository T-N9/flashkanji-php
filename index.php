<?php

include 'data.php';

// Allow requests from any origin
header('Access-Control-Allow-Origin: *');

// Allow all HTTP methods
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

// Allow specific headers
header('Access-Control-Allow-Headers: Content-Type');

// Get Kanji by character
function getKanjiByCharacter($character)
{
    global $kanjiData;

    foreach ($kanjiData as $kanji) {
        if ($kanji['Kanji'] == $character) {
            return $kanji;
        }
    }

    return null;
}

// Get random Kanji
function getRandomKanji($count)
{
    global $kanjiData;

    $randomKanji = [];

    if (1 < $count && $count <= count($kanjiData)) {
        // Get a random sample of Kanji from the data
        $randomKeys = array_rand($kanjiData, $count);

        foreach ($randomKeys as $key) {
            $randomKanji[] = $kanjiData[$key];
        }
    } elseif ($count === 1) {
        $randNo = rand(0, count($kanjiData));

        $randomKanji = $kanjiData[$randNo];
    } elseif ($count === 0 || $count > count($kanjiData)) {
        $randomKanji = $kanjiData;
        shuffle($randomKanji);
    }


    return $randomKanji;
}

$isRandIn = isset($_GET['rand']);
$isLimitIn = isset($_GET['limit']);
$isFromIn = isset($_GET['from']);
$isChapterIn = isset($_GET['chapter']);
$isLevelIn = isset($_GET['level']);

$randValue = $isRandIn ? intval($_GET['rand']) : 0;
$limitValue = $isLimitIn ? intval($_GET['limit']) : 10;
$fromValue = $isFromIn ? intval($_GET['from']) : 0;
$chapterValue = $isChapterIn ? intval($_GET['chapter']) : 1;
$levelValue = $isLevelIn ? intval($_GET['level']) : 5;

// Handle API request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($isRandIn) {
        $count = $randValue;

        // Return random Kanji
        $randomKanji = getRandomKanji($count);

        header('Content-Type: application/json');
        echo json_encode($randomKanji);

    } elseif ($isLimitIn) {

        if ($limitValue > 0) {
            // Return random Kanji
            $kanjiList = array_slice($kanjiData, $fromValue, $limitValue);

            header('Content-Type: application/json');
            echo json_encode($kanjiList);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Invalid 'rand' parameter"]);
        }
    } elseif ($isChapterIn) {
        $kanjiList = array_slice($kanjiData, $chapterValue*10-10, 10);

        header('Content-Type: application/json');
        echo json_encode($kanjiList);
    } else {
        header('Content-Type: application/json');
        echo json_encode($kanjiData);
    }


    // if (isset($_GET['character'])) {
    //     $character = $_GET['character'];
    //     $kanjiInfo = getKanjiByCharacter($character);

    //     if ($kanjiInfo !== null) {
    //         header('Content-Type: application/json');
    //         echo json_encode($kanjiInfo);
    //     } else {
    //         http_response_code(404);
    //         echo json_encode(["error" => "Kanji not found"]);
    //     }
    // } else {
    //     http_response_code(400);
    //     echo json_encode(["error" => "Character parameter missing"]);
    // }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}
?>