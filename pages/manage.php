<?php include "../includes/header.php"; ?>
<?php include "../utils/fetchers.php"; ?>
<?php include "../config/connectDb.php"; ?>
<div>
    <?php

    $kanjiData = fetchAllCharacters($conn);

    foreach($kanjiData as $kanji){
        echo "<div>{$kanji['kanji_character']}</div>";
    }
    ?>
</div>

<?php include "../includes/footer.php"; ?>