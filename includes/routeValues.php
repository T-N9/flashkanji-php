<?php
$isRandIn = isset($_GET['rand']);
$isLimitIn = isset($_GET['limit']);
$isFromIn = isset($_GET['from']);
$isChapterIn = isset($_GET['chapter']);
$isChaptersIn = isset($_GET['chapters']);
$isLevelIn = isset($_GET['level']);
$isLevelsIn = isset($_GET['levels']);
$isCharacterIn = isset($_GET['character']);
$isSearchIn = isset($_GET['search']);
$isQuizMode = isset($_GET['mode']);
$isShuffled = isset($_GET['shuffled']);
$isPageIn = isset($_GET['page']);
$isKanjisIn = isset($_GET['kanjis']);

// POST
$isActionIn = isset($_POST['action']);
$isIdIn = isset($_POST['id']);
$isOnyomiIn = isset($_POST['onyomi']);
$isKunyomiIn = isset($_POST['kunyomi']);
$isMeaningIn = isset($_POST['meaning']);

$randValue = $isRandIn ? intval($_GET['rand']) : 0;
$limitValue = $isLimitIn ? intval($_GET['limit']) : 10;
$fromValue = $isFromIn ? intval($_GET['from']) - 1 : 0;
$chapterValue = $isChapterIn ? intval($_GET['chapter']) : 1;
$chaptersValue = $isChaptersIn ? $_GET['chapters'] : 1;
$levelValue = $isLevelIn ? intval($_GET['level']) : 5;
$levelsValue = $isLevelsIn ? $_GET['levels'] : 0;
$characterValue = $isCharacterIn ? intval($_GET['character']) : 1;
$searchValue = $isSearchIn ? $_GET['search'] : '';
$quizModeValue = $isQuizMode ? intval($_GET['mode']) : 1;
$pageValue = $isPageIn ? intval($_GET['page']) : 1;
$kanjisValue = $isKanjisIn ? $_GET['kanjis'] : '';

// POST
$actionValue = $isActionIn ? intval($_POST['action']) : 'update';
$idValue = $isIdIn ? intval($_POST['id']) : 0;
$onyomiValue = $isOnyomiIn ? $_POST['onyomi'] : 'HIHI';
$kunyomiValue = $isKunyomiIn ? $_POST['kunyomi'] : '';
$meaningValue = $isMeaningIn ? $_POST['meaning'] : '';
?>