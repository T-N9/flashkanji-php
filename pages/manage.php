<?php include "../includes/header.php"; ?>
<?php include "../utils/fetchers.php"; ?>
<?php include "../config/connectDb.php"; ?>
<main class="container mx-auto my-4">
    <div class="flex flex-col lg:flex-row">
        <div class="flex-[5]"></div>
        <div class="flex-3 grid grid-cols-5 gap-3">
            <?php
            $kanjiData = fetchAllCharacters($conn);
            foreach($kanjiData as $kanji){
                echo "<div class='p-4 rounded shadow'>{$kanji['kanji_character']}</div>";
            }
            ?>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>