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

function getRandomJukugo($count)
{
    global $allJukugoData;

    $randomJukugo = [];

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


    return $randomJukugo;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($isRandIn) {
        $count = $randValue;
        // Return random Kanji
        $randomJukugo = getRandomJukugo($count);
        echo json_encode($randomJukugo);
    } elseif ($isKanjisIn) {
        // Explode the $kanjisValue into an array if there are multiple values
        $kanjisArray = explode(',', $kanjisValue);

        // Trim each value in the array
        $kanjisArray = array_map('trim', $kanjisArray);

        // Create a string for the LIKE clause if there are multiple values
        $likeClause = count($kanjisArray) > 1 ? "'%" . implode("%' OR jukugo_char LIKE '%", $kanjisArray) . "%'" : "'%$kanjisValue%'";

        // Build the SQL query with the LIKE clause
        $sql = "SELECT * FROM jukugo WHERE jukugo_char LIKE $likeClause";

        // Debug information
        echo "SQL Query: $sql\n";

        $jukugoData = fetchJukugoData($sql);

        echo "Fetched Data: ";
        print_r($jukugoData);

        echo json_encode($jukugoData);
    } else {
        echo json_encode($allJukugoData);
    }
}
?>