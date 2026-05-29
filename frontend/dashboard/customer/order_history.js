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

//Function for loading Customer's orders history
function loadOrdersHistory() {
  fetch("/Aqua-Jar/backend/api/ordersHistory.php")
    .then((res) => res.json())
    .then((data) => {
      console.log("FULL RESPONSE:", data);

      if (data.status === "success") {
        const table = document.getElementById("orderHistoryTable");

        table.innerHTML = ""; // IMPORTANT

        data.data.forEach((item) => {
          // Template literals (backticks ` `) in JavaScript

          const row = `
            <tr>
              <td>${item.distributor_name}</td>
              <td>${item.quantity}</td>
              <td>${item.unit_price}</td>
              <td>${item.unit}</td>
              <td>${item.total_price}</td>
              <td><span class="badge badge-delivered">${item.status}</span></td>
              <td><button onclick="window.location.href='billings.php?order_id=${item.order_id}'">View Invoice</td>
              <td><button onclick="openComplaintForm(${item.order_id})">Raise Complaint</td>
            </tr>
            `;

          table.innerHTML += row;
        });
      } else {
        // backend returned error (like "Unauthorized", "Empty")
        console.error(data.message);
        showFormMessage("orderHistory-message", data.message, false);
      }
    })
    .catch((error) => {
      // network / server crash / invalid JSON
      console.error("Fetch error:", error);

      showFormMessage(
        "orderHistory-message",
        "Something went wrong while loading order history",
        false,
      );
    });
}

function openComplaintForm(order_id) {
  document.getElementById("complaintForm").style.display = "block";
  document.getElementById("order_id").value = order_id;
}

//Handling what happens after the order form is submitted
document.getElementById("complaintForm").addEventListener("submit", (e) => {
  e.preventDefault();
  const form = document.getElementById("complaintForm");

  if (!validateComplaintForm()) {
    document.getElementById("complaint-message").textContent =
      "Please fix errors before submitting.";
    return;
  }

  fetch("/Aqua-Jar/backend/api/raiseComplaint.php", {
    method: "POST",
    body: new FormData(form),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        showFormMessage("complaint-message", data.message, true);
      } else {
        showFormMessage("complaint-message", data.message, false);
      }
    })
    .catch((error) => {
      // network / server crash / invalid JSON
      console.error("Fetch error:", error);

      showFormMessage(
        "complaint-message",
        "Something went wrong while raising complaint",
        false,
      );
    });
});

function validateComplaintForm() {
  let isValid = true;

  const message = document.getElementById("message");
  const image = document.getElementById("image");

  const messageError = message.nextElementSibling;
  const imageError = image.nextElementSibling;

  // Clear previous errors
  messageError.textContent = "";
  imageError.textContent = "";

  // ---------------- Message Validation ----------------
  if (message.value.trim().length < 5) {
    messageError.textContent =
      "Complaint message must be at least 5 characters.";
    isValid = false;
  }

  // ---------------- File Validation ----------------
  const file = image.files[0];

  if (file) {
    // Allowed image types
    const allowedTypes = ["image/jpeg", "image/png"];

    if (!allowedTypes.includes(file.type)) {
      imageError.textContent = "Only JPG and PNG images are allowed.";
      isValid = false;
    }

    // Max file size: 2MB
    const maxSize = 2 * 1024 * 1024;

    if (file.size > maxSize) {
      imageError.textContent = "Image size must be less than 2MB.";
      isValid = false;
    }
  }

  return isValid;
}

//Main init function
function initCustomerDashboard() {
  const saved = localStorage.getItem("theme") || "light";
  applyTheme(saved === "dark");
  loadOrdersHistory();

  // Five min auto reload (polling)
  setInterval(() => {
    loadOrdersHistory();
  }, 5000);
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Loaded");
  initCustomerDashboard();
});
