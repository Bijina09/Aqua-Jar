document.getElementById("login-form").addEventListener("submit", (e) => {
  e.preventDefault();
  const email = document.getElementById("email");
  const password = document.getElementById("password");

  console.log("Email:", email.value);
  console.log("Password:", password.value);

  regex = /^[a-z0-9]+@(gmail|yahoo|hotmail)\.com$/;

  if (!regex.test(email.value)) {
    alert("Please enter a valid email address");
  } else {
    alert("Login Successfull");
  }
});
