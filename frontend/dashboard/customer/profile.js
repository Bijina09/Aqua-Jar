/* ════ THEME ════════════════════════════════════════════════════════ */
function applyTheme(dark) {
  document.documentElement.setAttribute("data-theme", dark ? "dark" : "light");
  document.getElementById("theme-toggle-btn").textContent = dark ? "☀️" : "🌙";
  const sw = document.getElementById("dark-sw");
  if (sw) sw.checked = dark;
  localStorage.setItem("theme", dark ? "dark" : "light");
}

function toggleTheme() {
  const isDark = document.documentElement.getAttribute("data-theme") === "dark";
  applyTheme(!isDark);
}

function toggleThemeSwitch(el) {
  applyTheme(el.checked);
}

//This is where is load Customer Profile
function loadProfile() {
  const form = document.getElementById("profileForm");

  fetch("/Aqua-Jar/backend/api/customerProfile.php", {
    method: "POST",
    body: new FormData(form),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        document.getElementById("name").value = data.name;
        document.getElementById("address").value = data.address;
        document.getElementById("phone").value = data.phone;
        document.getElementById("email").value = data.email;
      } else {
        // backend returned error (like "Unauthorized", "User not found")
        console.error(data.message);

        showFormMessage(data.message, false);
      }
    })
    .catch((error) => {
      // network / server crash / invalid JSON
      console.error("Fetch error:", error);

      showFormMessage(
        "profile-message",
        "Something went wrong while loading profile",
        false,
      );
    });
}

//Handling editing profile
document.getElementById("editbtn").addEventListener("click", (e) => {
  document.querySelectorAll("#profileForm input").forEach((input) => {
    if (input.id !== "email") {
      input.disabled = false;
    }
  });

  document.getElementById("savebtn").style.display = "block";
});

//Handling the update submit button
document.getElementById("profileForm").addEventListener("submit", (e) => {
  e.preventDefault();
  const form = document.getElementById("profileForm");

  if (!validateProfile()) {
    document.getElementById("profile-message").textContent =
      "Please fix errors before submitting.";
    return;
  }
  //console.log([...new FormData(form)]);
  fetch("/Aqua-Jar/backend/api/updateCustomer.php", {
    method: "POST",
    body: new FormData(form),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        console.log(data.message);
        showFormMessage("profile-message", data.message, true);

        document
          .querySelectorAll("#form input")
          .forEach((i) => (i.disabled = true));

        document.getElementById("savebtn").style.display = "none";
      } else {
        showFormMessage("profile-message", data.message, false);
      }
    })
    .catch((error) => {
      console.error(error);
      showFormMessage("profile-message", "Something went wrong", false);
    });
});

function validateProfile() {
  //Input fields
  const name = document.getElementById("name");
  const address = document.getElementById("address");
  const phone = document.getElementById("phone");

  const nameValue = name.value.trim();
  const addressValue = address.value.trim();
  const phoneValue = phone.value.trim();

  const nameError = name.nextElementSibling;
  const addressError = address.nextElementSibling;
  const phoneError = phone.nextElementSibling;

  let isValid = true;

  // Clear previous errors
  nameError.textContent = "";
  addressError.textContent = "";
  phoneError.textContent = "";

  // Name
  if (nameValue === "") {
    nameError.textContent = "Name is required";
    isValid = false;
  }

  // Address
  if (addressValue === "") {
    addressError.textContent = "Address is required";
    isValid = false;
  }

  // Phone required
  if (phoneValue === "") {
    phoneError.textContent = "Phone is required";
    isValid = false;
  }

  // Phone regex (10 digits only)
  const phoneRegex = /^\d{10}$/;

  if (!phoneRegex.test(phoneValue)) {
    phoneError.textContent = "Enter valid 10-digit phone number";
    isValid = false;
  }

  return isValid;
}

//Main init function
function initCustomerDashboard() {
  const saved = localStorage.getItem("theme") || "light";
  applyTheme(saved === "dark");
  loadProfile();
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Loaded");
  initCustomerDashboard();
});
