//Used by other functions to display UI message
function showFormMessage(id, message, isSuccess) {
  const msg = document.getElementById(id);
  msg.textContent = message;
  msg.className = "form-message " + (isSuccess ? "success" : "error");
}

//Logout
function logout() {
  fetch("/Aqua-Jar/backend/api/logout.php")
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        // Clear all stored data
        localStorage.clear();
        sessionStorage.clear();

        // Redirect after 1 second
        setTimeout(() => {
          window.location.href = "/Aqua-Jar/frontend/auth/login.html";
        }, 1000);
      } else {
        console.error("Logout failed:", data.message);
      }
    })
    .catch((error) => {
      console.error("Logout error:", error);
    });
}
