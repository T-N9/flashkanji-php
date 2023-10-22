<?php

function fetchAllData($connection)
{
    /* Fetch All Kanji Data */
    $sql = "SELECT * FROM kanji";
    $result = $connection->query($sql);

    $allKanjiData = array();
    while ($row = $result->fetch_assoc()) {
        $allKanjiData[] = $row;
    }

    return json_encode($allKanjiData);
}

function fetchAllCharacters($connection)
{
    /* Fetch All Kanji Characters, ID */
    $sql = "SELECT id, kanji_character FROM kanji";
    $result = $connection->query($sql);

    $allKanjiCharacters = array();
    while ($row = $result->fetch_assoc()) {
        $allKanjiCharacters[] = $row;
    }

    return $allKanjiCharacters;
}
?>