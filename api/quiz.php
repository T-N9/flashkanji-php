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

function generateQuiz($quizData)
{
    $quizItems = [];

    foreach ($quizData as $item) {
        // Shuffle the onyomi options
        $onyomiOptions = [$item["onyomi"]];
        while (count($onyomiOptions) < 4) {
            $randomItem = $quizData[array_rand($quizData)];
            if (!in_array($randomItem["onyomi"], $onyomiOptions)) {
                $onyomiOptions[] = $randomItem["onyomi"];
            }
        }

        // Shuffle the options to make sure the correct answer is not always in the same position
        shuffle($onyomiOptions);

        $quizItems[] = [
            "id" => $item["id"],
            "kanji_character" => $item["kanji_character"],
            "options" => $onyomiOptions,
            "correct_option" => array_search($item["onyomi"], $onyomiOptions),
        ];
    }

    return $quizItems;
}

$quizCount = 10;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($isRandIn) {
        $count = $randValue;
        // Return random Kanji
        $randomKanji = getRandomKanji($count);
        $randomKanji_quized = generateQuiz($randomKanji);
        echo json_encode($randomKanji_quized, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else if ($isLimitIn) {
        /* Fetch Kanji Data by limits */
        $sql = "SELECT * FROM kanji ORDER BY id LIMIT $limitValue OFFSET $fromValue ";
        $limitedKanjiData = fetchKanjiData($sql);
        $limitedKanjiData_quized = generateQuiz($limitedKanjiData);
        echo json_encode($limitedKanjiData_quized, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    } else if ($isChapterIn && $isLevelIn) {
        /* Fetch Kanji Data by Chapters and Levels */
        $sql = "SELECT * FROM kanji WHERE chapter = $chapterValue AND level = $levelValue";

        $chapterKanjiData = fetchKanjiData($sql);
        $chapterKanjiData_quized = generateQuiz($chapterKanjiData);
        shuffle($chapterKanjiData_quized);
        echo json_encode($chapterKanjiData_quized, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else if ($isChaptersIn && $isLevelIn) {
        $sql = "SELECT * FROM kanji WHERE chapter IN ($chaptersValue) AND level = $levelValue";
        $chaptersKanjiData = fetchKanjiData($sql);
        $chaptersKanjiData_quized = generateQuiz($chaptersKanjiData);
        shuffle($chaptersKanjiData_quized);
        echo json_encode(array_slice($chaptersKanjiData_quized, 0, $quizCount), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else if ($isLevelIn) {
        /* Fetch Kanji Data only by Levels */
        $sql = "SELECT * FROM kanji WHERE level = $levelValue";

        $levelKanjiData = fetchKanjiData($sql);
        $levelKanjiData_quized = generateQuiz($levelKanjiData);
        shuffle($levelKanjiData_quized);
        echo json_encode(array_slice($levelKanjiData_quized, 0, $quizCount), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
        $defaultQuiz = generateQuiz(array_slice($allKanjiData, 0,10));
        echo json_encode($defaultQuiz,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }


} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}

?>