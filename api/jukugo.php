<?php
include '../config/connectDb.php';
include '../includes/headers.php';
include '../includes/routeValues.php';

/* Fetch All Jukugo Data */
$sql = "SELECT * FROM jukugo";
$allJukugoData = fetchJukugoData($sql);

function fetchJukugoData($sql)
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

function getRandomJukugo($count, $isLevel = 0)
{
    global $allJukugoData;

    $randomJukugo = [];

    if ($isLevel > 0) {
        $sql = "SELECT * FROM jukugo WHERE level=$isLevel";
        $jukugoByLevel = fetchJukugoData($sql);

        if (1 < $count && $count <= count($jukugoByLevel)) {
            // Get a random sample of Jukugo from the data
            $randomKeys = array_rand($jukugoByLevel, $count);

            foreach ($randomKeys as $key) {
                $randomJukugo[] = $jukugoByLevel[$key];
            }
        } elseif ($count === 1) {
            $randNo = rand(0, count($jukugoByLevel));

            $randomJukugo = $jukugoByLevel[$randNo];
        } elseif ($count === 0 || $count > count($jukugoByLevel)) {
            $randomJukugo = $jukugoByLevel;
            shuffle($randomJukugo);
        }

    } else {
        if (1 < $count && $count <= count($allJukugoData)) {
            // Get a random sample of Jukugo from the data
            $randomKeys = array_rand($allJukugoData, $count);

            foreach ($randomKeys as $key) {
                $randomJukugo[] = $allJukugoData[$key];
            }
        } elseif ($count === 1) {
            $randNo = rand(0, count($allJukugoData));

            $randomJukugo = $allJukugoData[$randNo];
        } elseif ($count === 0 || $count > count($allJukugoData)) {
            $randomJukugo = $allJukugoData;
            shuffle($randomJukugo);
        }
    }
    return $randomJukugo;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($isChapterIn && $isLevelIn) {
        $sql = "SELECT j.id,j.jukugo_char, MAX(j.english_meaning) AS english_meaning, MAX(j.hiragana) AS hiragana
        FROM jukugo j
        WHERE EXISTS (
            SELECT 1
            FROM kanji k
            WHERE k.chapter = $chapterValue
              AND k.level = $levelValue
              AND j.jukugo_char LIKE CONCAT('%', k.kanji_character, '%')
        )
        GROUP BY j.jukugo_char
        ORDER BY (
            SELECT MIN(k.id)
            FROM kanji k
            WHERE k.chapter = $chapterValue
              AND k.level = $levelValue
              AND j.jukugo_char LIKE CONCAT('%', k.kanji_character, '%')
        );
        ";
        $jukugoData = fetchJukugoData($sql);
        echo json_encode($jukugoData);
    } elseif ($isRandIn && $isLevelIn) {
        $count = $randValue;
        // Return random Kanji
        $randomJukugo = getRandomJukugo($count, $levelValue);
        // echo "helsdfj";
        echo json_encode($randomJukugo);
    } elseif ($isRandIn) {
        $count = $randValue;
        // Return random Kanji
        $randomJukugo = getRandomJukugo($count);
        echo json_encode($randomJukugo);
    } elseif ($isLevelIn) {
        $sql = "SELECT * FROM jukugo WHERE level=$levelValue";

        $jukugoData = fetchJukugoData($sql);
        echo json_encode($jukugoData);
    } elseif ($isKanjisIn) {
        $kanjisArray = explode(',', $kanjisValue);
        $kanjisArray = array_map('trim', $kanjisArray);

        $likeClause = count($kanjisArray) > 1 ? "'%" . implode("%' OR jukugo_char LIKE '%", $kanjisArray) . "%'" : "'%$kanjisValue%'";

        // Build the SQL query with the LIKE clause
        $sql = "SELECT jukugo_char, MAX(english_meaning) AS english_meaning, MAX(hiragana) AS hiragana
        FROM jukugo
        WHERE jukugo_char LIKE $likeClause
        GROUP BY jukugo_char;
        ";

        $jukugoData = fetchJukugoData($sql);

        echo json_encode($jukugoData);
    } else {
        echo json_encode($allJukugoData);
    }
}
?>