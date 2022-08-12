let navBurgerLinks = document.getElementById("nav-burger-links");
let menuIcon = document.getElementById("icon-menu");
let cancelIcon = document.getElementById("icon-cancel");

function toggleBurgerLinks() {
  if (navBurgerLinks.style.display === "block") {
    navBurgerLinks.style.display = "none";
    menuIcon.classList.remove("hidden");
    cancelIcon.classList.add("hidden");
  } else {
    navBurgerLinks.style.display = "block";
    menuIcon.classList.add("hidden");
    cancelIcon.classList.remove("hidden");
  }
}

let navBurger = document.getElementById("nav-burger");
let joinButton = document.getElementById("join-button");
let joinForm = document.getElementById("join-form");
let loginForm = document.getElementById("login-form");

function showJoinForm() {
  joinButton.style.display = "none";
  joinForm.classList.remove("hidden");
  navBurgerLinks.style.display = "none";
  navBurger.style.display = "none";
}

function showLoginForm() {
  loginForm.classList.remove("hidden");
  joinButton.style.display = "none";
  joinForm.classList.add("hidden");
  navBurgerLinks.style.display = "none";
  navBurger.style.display = "none";
  // let navLinks = document.getElementById("nav-links");
  // for (let i = 0; i < navLinks.length; i++) {
  //   navLinks.classList.add("invisible");
  // }
}