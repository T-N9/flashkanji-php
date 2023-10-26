document.addEventListener("DOMContentLoaded", function () {
  const updateForm = document.getElementById("updateKanjiForm");
  let createForm = document.getElementById("createKanjiForm");
  /* Form values */
  let form_character = updateForm.querySelector("#form_kanjiCharacter");
  let form_onyomi = updateForm.querySelector("#form_onyomi");
  let form_kunyomi = updateForm.querySelector("#form_kunyomi");
  let form_meaning = document.getElementById("form_meaning");
  let form_level = document.getElementById("form_level");
  let form_chapter = document.getElementById("form_chapter");
  let update_btn = document.getElementById("form_update");
  let delete_btn = document.getElementById("form_delete");
  const kanjiChars = document.querySelectorAll(".kanji_char");

  let create_character = createForm.querySelector("#create_kanjiCharacter");
  let create_onyomi = createForm.querySelector("#create_onyomi");
  let create_kunyomi = createForm.querySelector("#create_kunyomi");
  let create_meaning = document.getElementById("create_meaning");
  let create_level = document.getElementById("create_level");
  let create_chapter = document.getElementById("create_chapter");
  let cancel_create_btn = document.getElementById("cancel_create");
  let create_item_btn = document.getElementById("create_item");

  let isUpdating = true;

  let setNew_btn = document.getElementById("form_setNew");

  let character_review = document.getElementById("character_review");

  setNew_btn.addEventListener("click", function () {
    isUpdating = false;

    updateForm.classList += " hidden";
    createForm.classList = "p-4 sticky top-14 rounded shadow bg-white";
  });

  cancel_create_btn.addEventListener("click", function () {
    isUpdating = true;

    updateForm.classList = "p-4 sticky top-14 rounded shadow bg-white";
    createForm.classList += " hidden";
  });

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
    form_character.value = data.kanji_character;
    form_onyomi.value = data.onyomi;
    form_kunyomi.value = data.kunyomi;
    form_meaning.value = data.meaning;
    form_level.value = data.level;
    form_chapter.value = data.chapter;

    character_review.innerHTML = `<h1>${data.kanji_character}</h1>`;

    kanjiData = data;
    // console.log({ kanjiData });
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
    const kanjiCharacter = form_character.value;
    const onyomi = form_onyomi.value;
    const kunyomi = form_kunyomi.value;
    const meaning = form_meaning.value;
    const level = form_level.value;
    const chapter = form_chapter.value;

    let formData = {
      kanji_character: kanjiCharacter,
      onyomi: onyomi,
      kunyomi: kunyomi,
      meaning: meaning,
      level: level,
      chapter: chapter,
    };

    let updatedValue = compareObjects(kanjiData, formData);

    let queryParams = `id=${kanjiData?.id}`;
    let includeParams = ``;

    if (kanjiData) {
      for (const key in updatedValue) {
        if (
          updatedValue.hasOwnProperty(key) &&
          kanjiData[key] !== updatedValue[key] &&
          updatedValue[key] !== ""
        ) {
          queryParams += `&${key}=${updatedValue[key]}`;
          includeParams += `&${key}=${updatedValue[key]}`;
        }
      }
    }

    // console.log({ queryParams, includeParams });
    if (includeParams !== "") {
      fetch(`../api/update.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: queryParams,
      })
        .then((response) => response.text())
        .then((data) => {
          // console.log(data);

          alert("Data Updated");
          location.reload();
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    } else {
      alert("No updated data or form is incomplete.");
    }
  });

  create_item_btn.addEventListener("click", function () {
    const kanjiCharacter = create_character.value;
    const onyomi = create_onyomi.value;
    const kunyomi = create_kunyomi.value;
    const meaning = create_meaning.value;
    const level = create_level.value;
    const chapter = create_chapter.value;
    let isRequired = false;

    let formData = {
      kanji_character: kanjiCharacter,
      onyomi: onyomi,
      kunyomi: kunyomi,
      meaning: meaning,
      level: level,
      chapter: chapter,
    };



    let queryParams = `id=${kanjiData?.id}`;
    let includeParams = ``;

    if (kanjiData) {
      for (const key in formData) {
        if (
          formData.hasOwnProperty(key) &&
          formData[key] !== "" &&
          formData[key] !== "0"
        ) {
          queryParams += `&${key}=${formData[key]}`;
          includeParams += `&${key}=${formData[key]}`;
          isRequired = false;
        } else {
          isRequired = true;
        }
      }
    }

    // console.log({ queryParams, includeParams });
    if (includeParams !== "" && isRequired === false) {
      fetch(`../api/create.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: queryParams,
      })
        .then((response) => response.text())
        .then((data) => {
          // console.log(data);

          alert("Data Added.");
          location.reload();
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    } else {
      alert("Form is incomplete.");
    }
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
          // console.log(data);

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

  function updateChapters() {
    // Clear previous options
    form_chapter.innerHTML = "";
    create_chapter.innerHTML = "";

    var level_value = form_level.value;
    var create_level_value = create_level.value;

    // Define chapters based on selected level
    var chapterCount = {
      5: 11,
      4: 20,
      3: 30, // Add chapters for N3
      2: 40, // Add chapters for N2
      1: 50, // Add chapters for N1
    };

    for (let i = 1; i <= chapterCount[level_value]; i++) {
      let option = document.createElement("option");
      option.value = i;
      option.textContent = "Chapter " + i;
      form_chapter.appendChild(option);
    }

    for (let i = 1; i <= chapterCount[create_level_value]; i++) {
      let option = document.createElement("option");
      option.value = i;
      option.textContent = "Chapter " + i;
      create_chapter.appendChild(option);
    }
  }

  form_level.addEventListener("change", function () {
    updateChapters();
  });

  create_level.addEventListener("change", function () {
    updateChapters();
  });

  updateChapters();
});
