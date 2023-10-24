document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("kanjiForm");
  /* Form values */
  let character_value = form.querySelector("#form_kanjiCharacter");
  let onyomi_value = form.querySelector("#form_onyomi");
  let kunyomi_value = form.querySelector("#form_kunyomi");
  let meaning_value = document.getElementById("form_meaning");
  let update_btn = document.getElementById("form_update");
  let delete_btn = document.getElementById("form_delete");
  const kanjiChars = document.querySelectorAll(".kanji_char");

  let kanji_grid = document.getElementById("kanji_grid");
  let first_item_in_grid = kanji_grid.firstElementChild;
  let first_item_id;

  if (first_item_in_grid !== null) {
    var kanjiIdValue = first_item_in_grid.getAttribute("data-kanji-id");

    first_item_id = kanjiIdValue;
  } else {
    first_item_id = 0;
  }

  kanjiChars.forEach((char) => {
    char.addEventListener("click", function () {
      const kanjiId = this.dataset.kanjiId;
      fetchKanjiDetails(kanjiId);
    });
  });

  function fetchKanjiDetails(kanjiId) {
    fetch(`../api/?character=${kanjiId}`)
      .then((response) => response.json())
      .then((data) => populateForm(data[0]));
  }

  fetchKanjiDetails(first_item_id);

  let character_id = 1;
  let kanjiData;
  function populateForm(data) {
    character_id = data.id;
    character_value.value = data.kanji_character;
    onyomi_value.value = data.onyomi;
    kunyomi_value.value = data.kunyomi;
    meaning_value.value = data.meaning;

    kanjiData = data;
    console.log({ kanjiData });
  }

  function compareObjects(obj1, obj2) {
    let diffObject = {};

    for (const key in obj1) {
      if (obj1.hasOwnProperty(key) && obj2.hasOwnProperty(key)) {
        if (obj1[key] !== obj2[key]) {
          diffObject[key] = obj2[key];
        }
      }
    }

    return diffObject;
  }

  update_btn.addEventListener("click", function () {
    const kanjiCharacter = character_value.value;
    const onyomi = onyomi_value.value;
    const kunyomi = kunyomi_value.value;
    const meaning = meaning_value.value;

    let formData = {
      kanji_character: kanjiCharacter,
      onyomi: onyomi,
      kunyomi: kunyomi,
      meaning: meaning,
    };

    let updatedValue = compareObjects(kanjiData, formData);

    let queryParams = `id=${kanjiData?.id}`;
    let includeParams = ``;

    if (kanjiData) {
      for (const key in updatedValue) {
        if (
          updatedValue.hasOwnProperty(key) &&
          kanjiData[key] !== updatedValue[key]
        ) {
          queryParams += `&${key}=${updatedValue[key]}`;
          includeParams += `&${key}=${updatedValue[key]}`;
        }
      }
    }

    fetch(`../api/update.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: queryParams,
    })
      .then((response) => response.text())
      .then((data) => {
        console.log(data);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });

  let alert_box = document.getElementById("alert_box");

  function addEventListeners() {
    let alert_confirm = document.getElementById("alert_confirm");
    let alert_cancel = document.getElementById("alert_cancel");

    alert_cancel?.addEventListener("click", function () {
      let overlay = document.querySelector(".overlay");
      overlay.classList.remove("active");
      setTimeout(function () {
        overlay.parentNode.removeChild(overlay);
      }, 300);
    });

    alert_confirm?.addEventListener("click", function () {
      fetch(`../api/delete.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${kanjiData?.id}`,
      })
        .then((response) => response.text())
        .then((data) => {
          console.log(data);

          let overlay = document.querySelector(".overlay");
          overlay.classList.remove("active");
          setTimeout(function () {
            overlay.parentNode.removeChild(overlay);
          }, 300);
          setTimeout(() => {
            location.reload();
          }, 500);
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    });
  }

  delete_btn.addEventListener("click", function () {
    let overlay = document.createElement("div");
    overlay.classList.add("overlay");
    document.body.appendChild(overlay);

    setTimeout(function () {
      overlay.classList.add("active");
    }, 0); 

    overlay.innerHTML = `
          <div class="alert_box_wrapper bg-white p-8 rounded shadow">
              <p class="text">Are you sure to delete this Kanji?</p>
              <div class="flex gap-4 justify-around items-center">
                  <button id="alert_cancel" class="text-black px-4 py-2 mr-2 rounded">Cancel</button>
                  <button id="alert_confirm" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
              </div>
          </div>
      `;

    addEventListeners();
  });
});
