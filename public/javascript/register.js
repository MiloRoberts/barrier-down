document.getElementById("join-form").onsubmit = function onSubmit(form) {
  if (!confirmAccountValues()) {
    return false;
  } else {
    // feedback.innerHTML = "passed validation";
    return true;
  }
};

// THIS IS NOT WORKING AT ALL

// function checkSubmission(event) {
//   if (confirmAccountValues()) {
//   } else {
//     event.preventDefault();
//   }
// }

// const submitButton = document.getElementById("submitNewAccountForm");
const feedback = document.getElementById("feedback");
// submitButton.addEventListener("click", checkSubmission());

function confirmAccountValues() {
  var name = document.getElementById("name");
  var password = document.getElementById("password");
  var retyped = document.getElementById("retyped");
  var email = document.getElementById("email");
  // var subscribed = document.getElementById("subscribed");
  // var feedback = document.getElementById("feedback");
  if (name.value == "") {
    feedback.innerHTML = "<p>Please enter a username.</p>";
    name.focus();
    return false;
  } else if (password.value == "") {
    feedback.innerHTML = "<p>Please enter a password.</p>";
    password.focus();
    return false;
  } else if (retyped.value == "") {
    feedback.innerHTML = "<p>Please re-enter your password.</p>";
    retyped.focus();
    return false;
  } else if (password.value != retyped.value) {
    feedback.innerHTML = "<p>Your passwords do not match.</p>";
    retyped.focus();
    return false;
  } else if (email.value == "") {
    //   TO DO: CHECK THAT'S IT'S AN ACTUAL EMAIL ADDRESS
    feedback.innerHTML = "<p>Please enter a valid email.</p>";
    email.focus();
    return false;
  } else {
    return true;
  }
}