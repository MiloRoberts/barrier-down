// *********************
//    CONST VARIABLES
// *********************

const selectAllCheckbox = document.getElementById("select-all-checkbox");
const gameCheckboxes = document.querySelectorAll("input[name='game-checkbox']");
const beginButton = document.getElementById("begin-button");
const instructionsUnderstoodButton = document.getElementById(
  "instructions-understood-button"
);
const lexemeItem = document.getElementById("lexeme-item");
const lexemeMeaning = document.getElementById("lexeme-meaning");
const lexemeReading = document.getElementById("lexeme-reading");
const lexicalClass = document.getElementById("lexical-class");

const flashcardItem = document.getElementById("flashcard-item");
const flashcardMeaning = document.getElementById("flashcard-meaning");
const flashcardReading = document.getElementById("flashcard-reading");
const flashcardClass = document.getElementById("flashcard-class");

const difficultyButtons = document.querySelectorAll(".difficulty");
const flipFlashcardButton = document.getElementById("flip-flashcard-button");
const viewKanjiButton = document.getElementById("view-kanji-button");
const stopLearningButton = document.getElementById("stop-learning-button");
const goBackButton = document.getElementById("go-back-button");
const yesButton = document.getElementById("yes-button");
const noButton = document.getElementById("no-button");
const kanjiInfo = document.getElementById("kanji-info");

// *********************
//    VAR VARIABLES
// *********************

var lexemesArray = [];
var difficultyArray = [];

// ***************
//    FUNCTIONS
// ***************

function setReviewPoints(length) {
  let reviewPointsArray = [];
  if (length >= 400) {
    reviewPointsArray = [length, 250, 100, 25, 10];
  }
  if (length >= 200) {
    reviewPointsArray = [length, 125, 45, 15, 5];
  }
  if (length >= 100) {
    reviewPointsArray = [length, 75, 30, 10, 5];
  }
  if (length >= 40) {
    reviewPointsArray = [length, 32, 16, 8, 4];
  }
  if (length >= 20) {
    reviewPointsArray = [length, 16, 8, 4, 2];
  }
  if (length >= 10) {
    reviewPointsArray = [length, 8, 6, 4, 2];
  } else {
    reviewPointsArray = [length, length, length, length, length];
  }
  return reviewPointsArray;
}

function startFlashcard() {
  flashcardMeaning.classList.add("invisible");
  flashcardReading.classList.add("invisible");
  hideDifficultyButtons();
  viewKanjiButton.classList.add("hidden");
  stopLearningButton.classList.add("hidden");
  flipFlashcardButton.classList.remove("hidden");
  flashcardItem.innerHTML = lexemesArray[0].item;
  flashcardMeaning.innerHTML = lexemesArray[0].meaning;
  flashcardReading.innerHTML = lexemesArray[0].reading;
  flashcardClass.innerHTML = lexemesArray[0].classes;
}

function displayDifficultyButtons() {
  // it might be better to use difficulty-container instead
  for (let i = 0; i < difficultyButtons.length; i++) {
    difficultyButtons[i].classList.remove("hidden");
  }
}

function hideDifficultyButtons() {
  // it might be better to use difficulty-container instead
  for (let i = 0; i < difficultyButtons.length; i++) {
    difficultyButtons[i].classList.add("hidden");
  }
}

function sendCardBack(numberOfPlaces) {
  lexemesArray.splice(numberOfPlaces, 0, lexemesArray[0]);
  lexemesArray.shift();
  startFlashcard();
}

// *********************
//    EVENT LISTENERS
// *********************

selectAllCheckbox.addEventListener("click", function () {
  if (selectAllCheckbox.checked) {
    for (let i = 0; i < gameCheckboxes.length; i++) {
      gameCheckboxes[i].checked = true;
    }
  } else {
    for (let i = 0; i < gameCheckboxes.length; i++) {
      gameCheckboxes[i].checked = false;
    }
  }
});

beginButton.addEventListener("click", function () {
  let gameSelectedFlag = false;
  for (let i = 0; i < gameCheckboxes.length; i++) {
    if (gameCheckboxes[i].checked == true) {
      gameSelectedFlag = true;
    }
  }
  if (gameSelectedFlag) {
    document.getElementById("initial-screen").classList.add("hidden");

    let gamesList = "";
    let emptyFlag = true;
    for (let i = 0; i < gameCheckboxes.length; i++) {
      if (gameCheckboxes[i].checked) {
        let gameID = gameCheckboxes[i].parentElement.parentElement.id;
        gameID = gameID.substring(1);
        if (emptyFlag) {
          gamesList = gameID;
          emptyFlag = false;
        } else {
          gamesList += ", " + gameID;
        }
      }
    }
    // console.log("gamesList: " + gamesList); // testing only

    dataRequest = new XMLHttpRequest();
    dataRequest.onload = function () {
      // console.log(this.responseText);
      lexemesArray = JSON.parse(this.responseText);

      // console.log("lexemesArray: " + lexemesArray);

      // if (dataRequest.readyState == 4 && dataRequest.status == 200) {
      //   lexemesArray = this.responseText;
      // }
    };
    // dataRequest.open("GET", "/flashcards.php", true);
    // POST and ./getflashcards aren't right
    // also change button to submit? 
    dataRequest.open("POST", "/flashcards", true);
    dataRequest.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    dataToSend = "&gamesList=" + gamesList;
    dataToSend += "&_token=";
    dataToSend += document.getElementById('begin-button').dataset['csrf'];
    dataRequest.send(dataToSend);
    // console.log(dataToSend);

    document.getElementById("instructions-screen").classList.remove("hidden");
  } else {
    alert("At least one game must be selected.");
  }
});

instructionsUnderstoodButton.addEventListener("click", function () {
  // for bug testing
  // console.log("after instructions");
  // for (let i = 0; i < lexemesArray.length; i++) {
  //   console.log(lexemesArray[i]);
  //   console.log(difficultyArray);
  // }
  document.getElementById("instructions-screen").classList.add("hidden");
  let arrayCopy;
  let randomIndex;
  for (let i = 0; i < lexemesArray.length; i++) {
    arrayCopy = lexemesArray[i];
    randomIndex = Math.floor(Math.random() * lexemesArray.length);
    lexemesArray[i] = lexemesArray[randomIndex];
    lexemesArray[randomIndex] = arrayCopy;
  }
  difficultyArray = setReviewPoints(lexemesArray.length);
  document.getElementById("flashcard-screen").classList.remove("hidden");
  flipFlashcardButton.classList.remove("hidden");
  startFlashcard();
  // console.log("lexemesArray: " + lexemesArray); //testing only
});

flipFlashcardButton.addEventListener("click", function () {
  // // for bug testing
  // console.log("after flip");
  // console.log(difficultyArray);
  // for (let i = 0; i < lexemesArray.length; i++) {
  //   console.log(lexemesArray[i]);
  // }

  flipFlashcardButton.classList.add("hidden");
  flashcardMeaning.classList.remove("invisible");
  flashcardReading.classList.remove("invisible");
  displayDifficultyButtons();
  viewKanjiButton.classList.remove("hidden");
  stopLearningButton.classList.remove("hidden");
});

for (let i = 0; i < difficultyButtons.length; i++) {
  difficultyButtons[i].addEventListener("click", function () {
    sendCardBack(difficultyArray[i]);
  });
}

stopLearningButton.addEventListener("click", function () {
  document.getElementById("stop-learning-screen").classList.remove("hidden");
  document.getElementById("flashcard-screen").classList.add("hidden");
  viewKanjiButton.classList.add("hidden");
  stopLearningButton.classList.add("hidden");
});

noButton.addEventListener("click", function () {
  document.getElementById("stop-learning-screen").classList.add("hidden");
  document.getElementById("flashcard-screen").classList.remove("hidden");
  viewKanjiButton.classList.remove("hidden");
  stopLearningButton.classList.remove("hidden");
});

yesButton.addEventListener("click", function () {
  let unlearningLexemeID = lexemesArray[0].lexemeID;
  document.getElementById("stop-learning-screen").classList.add("hidden");
  document.getElementById("flashcard-screen").classList.remove("hidden");

  dataRequest = new XMLHttpRequest();
  dataRequest.open("POST", "./removeUserLexeme.php", true);
  dataRequest.setRequestHeader(
    "Content-type",
    "application/x-www-form-urlencoded"
  );
  dataToSend = "&lexemeID=" + unlearningLexemeID;
  dataRequest.send(dataToSend);

  lexemesArray.shift();
  startFlashcard();
  difficultyArray = setReviewPoints(lexemesArray.length);
});

viewKanjiButton.addEventListener("click", function () {
  viewKanjiButton.classList.add("hidden");
  stopLearningButton.classList.add("hidden");
  hideDifficultyButtons();
  goBackButton.classList.remove("hidden");
  document.getElementById("flashcard-screen").classList.add("hidden");
  kanjiInfo.classList.remove("hidden");

  dataRequest = new XMLHttpRequest();
  dataRequest.onload = function () {
    kanjiInfo.innerHTML = this.responseText;
  };
  dataRequest.open("POST", "./getKanji.php", true);
  dataRequest.setRequestHeader(
    "Content-type",
    "application/x-www-form-urlencoded"
  );
  let lexemeID = lexemesArray[0].lexemeID;
  dataToSend = "&lexemeID=" + lexemeID;
  dataRequest.send(dataToSend);
});

goBackButton.addEventListener("click", function () {
  goBackButton.classList.add("hidden");
  document.getElementById("flashcard-screen").classList.remove("hidden");
  kanjiInfo.classList.add("hidden");
  kanjiInfo.innerHTML = "";
  displayDifficultyButtons();
  viewKanjiButton.classList.remove("hidden");
  stopLearningButton.classList.remove("hidden");
});
