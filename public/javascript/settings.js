const gameCheckboxes = document.querySelectorAll("input[name='game-checkbox']");

const lexemeCheckboxes = document.querySelectorAll(
  "input[name='lexeme-checkbox']"
);

// temporarily removed
// const mailingListCheckbox = document.getElementById("mailing-list-checkbox");

// function toggleSubscription() {
//   if (mailingListCheckbox.checked) {
//     dataRequest = new XMLHttpRequest();
//     dataRequest.open("POST", "./addSubscriber.php", true);
//     dataRequest.setRequestHeader(
//       "Content-type",
//       "application/x-www-form-urlencoded"
//     );
//     dataToSend = "";
//     dataRequest.send(dataToSend);
//   } else {
//     dataRequest = new XMLHttpRequest();
//     dataRequest.open("POST", "./removeSubscriber.php", true);
//     dataRequest.setRequestHeader(
//       "Content-type",
//       "application/x-www-form-urlencoded"
//     );
//     dataToSend = "";
//     dataRequest.send(dataToSend);
//   }
// }

function toggleGame(checkbox) {
  let gameID = checkbox.parentElement.parentElement.id;
  gameID = gameID.substring(1);
  if (checkbox.checked) {
    dataRequest = new XMLHttpRequest();
    dataRequest.open("POST", "/settings/gamesusers/store", true);
    dataRequest.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    dataToSend = "&gameID=" + gameID;
    dataToSend += "&_token="
     + document.getElementById('settings-form').dataset['csrf'];
    dataRequest.send(dataToSend);
    let learningFlag;
    for (let i = 0; i < lexemeCheckboxes.length; i++) {
      let lexemeID = lexemeCheckboxes[i].parentElement.parentElement.id;
      lexemeID = lexemeID.substring(1);
      if (!lexemeCheckboxes[i].checked) {
        dataRequest = new XMLHttpRequest();
        dataRequest.onload = function () {
          learningFlag = this.responseText;
          if (learningFlag == "1") {
            lexemeCheckboxes[i].checked = true;
          }
        };
        dataRequest.open("POST", "/settings/lexemesusers/toggle", true);
        dataRequest.setRequestHeader(
          "Content-type",
          "application/x-www-form-urlencoded"
        );
        dataToSend = "&gameID=" + gameID + "&lexemeID=" + lexemeID;
        dataToSend += "&_token="
         + document.getElementById('settings-form').dataset['csrf'];
        dataRequest.send(dataToSend);
      }
    }
  } else {
    dataRequest = new XMLHttpRequest();
    dataRequest.open("POST", "/settings/gamesusers/destroy", true);
    dataRequest.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    dataToSend = "&gameID=" + gameID;
    dataToSend += "&_token="
     + document.getElementById('settings-form').dataset['csrf'];
    dataRequest.send(dataToSend);
    let learningFlag;
    for (let i = 0; i < lexemeCheckboxes.length; i++) {
      let lexemeID = lexemeCheckboxes[i].parentElement.parentElement.id;
      lexemeID = lexemeID.substring(1);
      if (lexemeCheckboxes[i].checked) {
        dataRequest = new XMLHttpRequest();
        dataRequest.onload = function () {
          learningFlag = this.responseText;
          if (learningFlag == "0") {
            lexemeCheckboxes[i].checked = false;
          }
        };
        dataRequest.open("POST", "/settings/lexemesusers/toggle", true);
        dataRequest.setRequestHeader(
          "Content-type",
          "application/x-www-form-urlencoded"
        );
        dataToSend = "&gameID=" + gameID + "&lexemeID=" + lexemeID;
        dataToSend += "&_token="
         + document.getElementById('settings-form').dataset['csrf'];
        dataRequest.send(dataToSend);
      }
    }
  }
  location.reload(); //this is slow and clumsy
}

function toggleLexeme(checkbox) {
  let lexemeID = checkbox.parentElement.parentElement.id;
  lexemeID = lexemeID.substring(1);
  if (checkbox.checked) {
    dataRequest = new XMLHttpRequest();
    dataRequest.open("POST", "/settings/lexemesusers/store", true);
    dataRequest.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    dataToSend = "&lexemeID=" + lexemeID;
    dataToSend += "&_token="
     + document.getElementById('settings-form').dataset['csrf'];
    dataRequest.send(dataToSend);
  } else {
    dataRequest = new XMLHttpRequest();
    dataRequest.open("POST", "/settings/lexemesusers/destroy", true);
    dataRequest.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    dataToSend = "&lexemeID=" + lexemeID;
    dataToSend += "&_token="
     + document.getElementById('settings-form').dataset['csrf'];
    dataRequest.send(dataToSend);
  }
}

for (let i = 0; i < gameCheckboxes.length; i++) {
  gameCheckboxes[i].addEventListener("change", function () {
    toggleGame(this);
  });
}

for (let i = 0; i < lexemeCheckboxes.length; i++) {
  lexemeCheckboxes[i].addEventListener("change", function () {
    toggleLexeme(this);
  });
}

// to be added back in later
// mailingListCheckbox.addEventListener("change", function () {
//   toggleSubscription();
// });
