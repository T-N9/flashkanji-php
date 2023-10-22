<?php
$isRandIn = isset($_GET['rand']);
$isLimitIn = isset($_GET['limit']);
$isFromIn = isset($_GET['from']);
$isChapterIn = isset($_GET['chapter']);
$isLevelIn = isset($_GET['level']);

$randValue = $isRandIn ? intval($_GET['rand']) : 0;
$limitValue = $isLimitIn ? intval($_GET['limit']) : 10;
$fromValue = $isFromIn ? intval($_GET['from']) - 1 : 0;
$chapterValue = $isChapterIn ? intval($_GET['chapter']) : 1;
$levelValue = $isLevelIn ? intval($_GET['level']) : 5;
?>