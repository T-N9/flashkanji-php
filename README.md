# ⚡FlashKanji API

This API provides access to a collection of Japanese Kanji characters along with their associated readings and meanings. You can retrieve random Kanji characters, a specific number of Kanji, or Kanji based on chapters or levels.

## Base URL
`https://flashkanji.000webhostapp.com/` 

## Get Random Kanji

Retrieves a random selection of Kanji characters.
#### Request
`GET /?rand={count}` 

-   `count` (integer): The number of random Kanji characters to retrieve.
- if `count === 0` , all kanji character data will be shuffled.

## Get Kanji by Limit

Retrieves a specified number of Kanji characters.

#### Request
`GET /?limit={limit}&from={start}` 

-   `limit` (integer): The number of Kanji characters to retrieve.
-   `from` (integer): The starting index for retrieving Kanji characters.
## Get Kanji by Chapter

Retrieves a set of Kanji characters based on chapters (based on Kanji Challenge Books).

#### Request
`GET /?chapter={chapter}` 

-   `chapter` (integer): The chapter number.

## Get Kanji by Level

Retrieves a set of Kanji characters based on JLPT (N5, N4, N3, N2, N1) levels. This version is available only N5 level for now.

#### Request
`GET /?level={level}` 

-   `level` (integer): The level number.
