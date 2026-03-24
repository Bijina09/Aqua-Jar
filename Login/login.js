//Get form elements
const loginForm = document.getElementById("login-form");
const email = document.getElementById("email");
const password = document.getElementById("password");
const rememberMe = document.getElementById("remember");
const emailError = document.querySelector("#email + .error-msg");
const passwordError = document.querySelector("#password + .error-msg");

//Regex for email validation
const regex = /^[a-z0-9]+@(gmail|yahoo|hotmail)\.com$/;

//Load saved email when page opens
window.addEventListener("load", () => {
  const savedEmail = localStorage.getItem("email");
  if (savedEmail) {
    email.value = savedEmail;
    rememberMe.checked = true;
  }
});

//Form submission event
loginForm.addEventListener("submit", (e) => {
  e.preventDefault();

  //Reset error messages and styles
  emailError.textContent = "";
  passwordError.textContent = "";
  email.style.borderColor = "#ccc";
  password.style.borderColor = "#ccc";

  const emailValue = email.value.trim();
  const passwordValue = password.value.trim();

  //Check if fields are empty
  if (emailValue === "" || passwordValue === "") {
    emailError.textContent = emailValue === "" ? "Email is required" : "";
    passwordError.textContent =
      passwordValue === "" ? "Password is required" : "";
    return;
  }

  //Email validation
  if (!regex.test(emailValue)) {
    email.style.borderColor = "red";
    emailError.textContent = "Please enter a valid email address";
    return;
  }

  //Password validation
  if (passwordValue.length < 8) {
    password.style.borderColor = "red";
    passwordError.textContent = "Password must be at least 8 characters";
    return;
  }

  //Remember me functionality
  if (rememberMe.checked) {
    localStorage.setItem("email", emailValue);
  } else {
    localStorage.removeItem("email");
  }

  alert("Login successful!");
});
