<?php include "../includes/header.php"; ?>
<?php include "../utils/fetchers.php"; ?>
<?php include "../config/connectDb.php"; ?>

<main class="container mx-4 md:mx-auto my-4">
    <div class="flex flex-col gap-4 lg:flex-row">
        <div class="flex-[5] relative">
            <form action="../api/update.php" method="post" id="updateKanjiForm"
                class="p-4 sticky top-6 rounded shadow bg-white">
                <div class="flex gap-3 flex-col md:flex-row">
                    <!-- Kanji Character -->
                    <div class="mb-4 flex-[2]">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="form_kanjiCharacter">
                            Kanji Character
                        </label>
                        <input class="form-item form_character" id="form_kanjiCharacter" type="text"
                            placeholder="Enter Kanji Character" name="form_kanjiCharacter" required>
                    </div>
                    <div class="flex-[8]">
                        <div class="grid gap-3 grid-cols-2">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="form_onyomi">
                                    Onyomi
                                </label>
                                <input class="form-item second_character" id="form_onyomi" type="text"
                                    placeholder="Enter Onyomi" name="form_onyomi" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="form_kunyomi">
                                    Kunyomi
                                </label>
                                <input class="form-item second_character" id="form_kunyomi" type="text"
                                    placeholder="Enter Kunyomi" name="form_kunyomi" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="form_meaning">
                                Meaning
                            </label>
                            <input class="form-item" id="form_meaning" type="text" placeholder="Enter Meaning"
                                name="form_meaning" required>
                        </div>
                        <div class="grid gap-3 grid-cols-2">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="form_level">
                                    Select level
                                </label>
                                <div class="relative inline-block w-full">
                                    <select aria-placeholder="Select level" name="form_level" id="form_level"
                                        class="form-item" required>
                                        <option value=5>N5</option>
                                        <option value=4>N4</option>
                                        <option value=3>N3</option>
                                        <option value=2>N2</option>
                                        <option value=1>N1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="form_chapter">
                                    Select chapter
                                </label>
                                <div class="relative inline-block w-full">
                                    <select aria-placeholder="Select chapter" name="form_chapter" id="form_chapter"
                                        class="form-item" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-success shadow text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        id="form_setNew" type="button">
                        <img width="20" height="20" src="../assets/plus-solid.svg" />
                    </button>
                    <div class="flex gap-2">

                        <button
                            class="bg-main shadow text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            id="form_update" type="button">
                            Update
                        </button>
                        <button
                            class="bg-white shadow text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            id="form_delete" type="button">
                            <img width="20" height="20" src="../assets/trash-solid.svg" />
                        </button>
                    </div>
                </div>
            </form>

            <form action="../api/create.php" method="post" id="createKanjiForm" class=" hidden">
                <div class="flex gap-3 flex-col md:flex-row">
                    <div class="mb-4 flex-[2]">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="create_kanjiCharacter">
                            Kanji Character
                        </label>
                        <input class="form-item w-[115px]  form_character" id="create_kanjiCharacter" type="text"
                            placeholder="Enter Kanji Character" name="create_kanjiCharacter" required>
                    </div>
                    <div clas="flex-[8]">
                        <div class="grid gap-3 grid-cols-2">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="create_onyomi">
                                    Onyomi
                                </label>
                                <input class="form-item second_character" id="create_onyomi" type="text"
                                    placeholder="Enter Onyomi" name="create_onyomi" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="create_kunyomi">
                                    Kunyomi
                                </label>
                                <input class="form-item second_character" id="create_kunyomi" type="text"
                                    placeholder="Enter Kunyomi" name="create_kunyomi" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="create_meaning">
                                Meaning
                            </label>
                            <input class="form-item" id="create_meaning" type="text" placeholder="Enter Meaning"
                                name="create_meaning" required>
                        </div>
                        <div class="grid gap-3 grid-cols-2">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="create_level">
                                    Select level
                                </label>
                                <div class="relative inline-block w-full">
                                    <select aria-placeholder="Select level" name="create_level" id="create_level"
                                        class="form-item" required>
                                        <option value=0 selected>JLPT level</option>
                                        <option value=5>N5</option>
                                        <option value=4>N4</option>
                                        <option value=3>N3</option>
                                        <option value=2>N2</option>
                                        <option value=1>N1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="create_chapter">
                                    Select chapter
                                </label>
                                <div class="relative inline-block w-full">
                                    <select aria-placeholder="Select chapter" name="create_chapter" id="create_chapter"
                                        class="form-item" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2">
                    <button
                        class="bg-main shadow text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        id="create_item" type="button">
                        Create
                    </button>


                    <button
                        class="border-solid border-2 border-red-800 bg-white hover:border-red-800 shadow text-gray-500 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        id="cancel_create" type="button">
                        Cancel
                    </button>

                </div>
            </form>

        </div>
        <div id="kanji_grid" class="flex-3 grid grid-cols-5 gap-3">
            <?php
            $kanjiData = fetchAllCharacters($conn);
            foreach ($kanjiData as $kanji) {
                echo "<div class='p-4 bg-white kanji_char text-4xl text-center rounded shadow cursor-pointer' data-kanji-id='{$kanji['id']}'>{$kanji['kanji_character']}</div>";
            }
            ?>
        </div>
    </div>
</main>

<script src="../js/manage.js"></script>
<?php include "../includes/footer.php"; ?>