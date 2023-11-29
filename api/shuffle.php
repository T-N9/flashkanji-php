<?php
include '../config/connectDb.php';
include '../includes/headers.php';
include '../includes/routeValues.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $mysql = "SELECT * FROM kanji";

    if ($isLevelsIn) {
        // Use string interpolation to include the levels in the query
        $mysql .= " WHERE level IN ($levelsValue)";
    }

    // Complete the query with the RAND() ordering
    $mysql .= " ORDER BY RAND()";

    $result = $conn->query($mysql);

    if ($result === false) {
        return [];
    }

    $data = [];
    $pages = 0;
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if (count($data) > 0) {
        $pages = count($data) / 10;
    }

    $response = [
        'pages' => $pages,
        'data' => $data
    ];

    echo json_encode($response);
}
$conn->close();
?>