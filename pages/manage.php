<?php include "../includes/header.php"; ?>
<?php include "../utils/fetchers.php"; ?>
<?php include "../config/connectDb.php"; ?>

<main class="container mx-4 md:mx-auto my-4">
    <div class="flex flex-col gap-4 lg:flex-row">
        <div class="flex-[5] relative">
            <form action="../api/update.php" method="post" id="kanjiForm"
                class="p-4 sticky top-14 rounded shadow bg-white">
                <div class="absolute -left-6 top-0 p-4 text-2xl font-bold shadow-lg rounded-full bg-orange-200" id="character_review"></div>
                <div class="grid gap-3 grid-cols-2 lg:grid-cols-3">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="form_kanjiCharacter">
                            Kanji Character
                        </label>
                        <input
                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="form_kanjiCharacter" type="text" placeholder="Enter Kanji Character"
                            name="form_kanjiCharacter">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="form_onyomi">
                            Onyomi
                        </label>
                        <input
                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="form_onyomi" type="text" placeholder="Enter Onyomi" name="form_onyomi">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="form_kunyomi">
                            Kunyomi
                        </label>
                        <input
                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="form_kunyomi" type="text" placeholder="Enter Kunyomi" name="form_kunyomi">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="form_meaning">
                            Meaning
                        </label>
                        <input
                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="form_meaning" type="text" placeholder="Enter Meaning" name="form_meaning">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="form_level">
                            Select level
                        </label>
                        <div class="relative inline-block w-32">
                            <select aria-placeholder="Select level" name="form_level" id="form_level"
                                class="block cursor-pointer appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
                                <option>5</option>
                                <option>4</option>
                                <option>3</option>
                                <option>2</option>
                                <option>1</option>
                            </select>
                        </div>

                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="form_chapter">
                            Select chapter
                        </label>
                        <div class="relative inline-block w-32">
                            <select aria-placeholder="Select chapter" name="form_chapter" id="form_chapter"
                                class="block cursor-pointer appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
                            </select>
                        </div>

                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 shadow text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        id="form_update" type="button">
                        Update
                    </button>
                    <button
                        class="bg-red-500 hover:bg-red-700 shadow text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        id="form_delete" type="button">
                        Delete
                    </button>
                </div>
            </form>

        </div>
        <div id="kanji_grid" class="flex-3 grid grid-cols-5 gap-3">
            <?php
            $kanjiData = fetchAllCharacters($conn);
            foreach ($kanjiData as $kanji) {
                echo "<div class='p-4 kanji_char text-4xl text-center rounded shadow cursor-pointer' data-kanji-id='{$kanji['id']}'>{$kanji['kanji_character']}</div>";
            }
            ?>
        </div>
    </div>
</main>

<script src="../js/manage.js"></script>
<?php include "../includes/footer.php"; ?>