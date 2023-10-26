<?php include "../includes/header.php"; ?>
<div class="container mx-auto py-8">

    <!-- Section: FlashKanji API -->
    <section class="mb-8">
        <h1 class="text-4xl font-bold mb-4">⚡FlashKanji API</h1>
        <p class="mb-4">This API provides access to a collection of Japanese Kanji characters along with their
            associated readings and meanings. You can retrieve random Kanji characters, a specific number of Kanji, or
            Kanji based on chapters or levels.</p>
    </section>

    <!-- Section: Base URL -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-2">Base URL</h2>
        <code class="bg-gray-100 p-2 mb-4">https://flashkanji.000webhostapp.com/api/</code>
    </section>

    <!-- Section: Get Random Kanji -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-2">Get Random Kanji</h2>
        <p>Retrieves a random selection of Kanji characters.</p>
        <h3 class="text-xl font-bold mt-2 mb-1">Request</h3>
        <code class="bg-gray-100 p-2 mb-4">GET /api/?rand={count}</code>
        <ul class="list-disc pl-8 mb-4">
            <li><strong>count</strong> (integer): The number of random Kanji characters to retrieve.</li>
            <li>if <code>count === 0</code>, all kanji character data will be shuffled.</li>
        </ul>
    </section>

    <!-- Section: Get Kanji by Limit -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-2">Get Kanji by Limit</h2>
        <p>Retrieves a specified number of Kanji characters.</p>
        <h3 class="text-xl font-bold mt-2 mb-1">Request</h3>
        <code class="bg-gray-100 p-2 mb-4">GET /api/?limit={limit}&from={start}</code>
        <ul class="list-disc pl-8 mb-4">
            <li><strong>limit</strong> (integer): The number of Kanji characters to retrieve.</li>
            <li><strong>from</strong> (integer): The starting index for retrieving Kanji characters.</li>
        </ul>
    </section>

    <!-- Section: Get Kanji by Chapter -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-2">Get Kanji by Chapter</h2>
        <p>Retrieves a set of Kanji characters based on chapters (based on Kanji Challenge Books).</p>
        <h3 class="text-xl font-bold mt-2 mb-1">Request</h3>
        <code class="bg-gray-100 p-2 mb-4">GET /api/?chapter={chapter}</code>
        <ul class="list-disc pl-8 mb-4">
            <li><strong>chapter</strong> (integer): The chapter number.</li>
        </ul>
    </section>

    <!-- Section: Get Kanji by Level -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-2">Get Kanji by Level</h2>
        <p>Retrieves a set of Kanji characters based on JLPT (N5, N4, N3, N2, N1) levels. This version is available only
            N5 level for now.</p>
        <h3 class="text-xl font-bold mt-2 mb-1">Request</h3>
        <code class="bg-gray-100 p-2 mb-4">GET /api/?level={level}</code>
        <ul class="list-disc pl-8 mb-4">
            <li><strong>level</strong> (integer): The level number.</li>
        </ul>
    </section>

</div>


<?php include "../includes/footer.php"; ?>