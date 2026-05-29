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

// function badgeClass(status) {
//   const map = {
//     pending: "badge-pending",
//     accepted: "badge-accepted",
//     "out for delivery": "badge-outfordelivery",
//     delivered: "badge-delivered",
//     rejected: "badge-rejected",
//     OPEN: "badge-open",
//     resolved: "badge-resolved",
//   };
//   return map[status.toLowerCase()] || "badge-pending";
// }
//

function loadDashboardStats() {
  fetch(`/Aqua-Jar/backend/api/customer/getDashboardStats.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      if (data.status === "success") {
        document.getElementById("stat-total").textContent =
          data.total_orders ?? 0;
        document.getElementById("stat-arriving").textContent =
          data.arriving ?? 0;
        document.getElementById("stat-delivered").textContent =
          data.delivered ?? 0;
        document.getElementById("stat-complaints").textContent =
          data.open_complaints ?? 0;
      } else {
        console.error(data.message);
      }
    })
    .catch((error) => {
      console.error("Fetch error:", error);
      showFormMessage("stats-message", "Something went wrong", false);
    });
}

//Function for loading the available jars
function loadJars() {
  fetch("/Aqua-Jar/backend/api/browseJars.php")
    .then((res) => res.json())
    .then((data) => {
      console.log("FULL RESPONSE:", data);
      if (data.status === "success") {
        const table = document.getElementById("jarTable");

        //Important for clearing old rows each time refreshing
        table.innerHTML = "";
        data.data.forEach((item) => {
          // Template literals (backticks ` `) in JavaScript
          const row = `
          <tr>
            <td>${item.distributor_name}</td>
            <td>${item.price}</td>
            <td>${item.unit}</td>
            <td>${item.stock}</td>
            <td>${item.service_area}</td>
            <td>
             <button onclick="openForm(${item.distributor_id},${item.jar_id},'${item.unit}',${item.price})">
             Order</button>
            </td>
          </tr>
          `;
          table.innerHTML += row;
        });
      } else {
        // backend returned error (like "Unauthorized", "Empty")
        console.error(data.message);
        showFormMessage("jar-message", data.message, false);
      }
    })
    .catch((error) => {
      // network / server crash / invalid JSON
      console.error("Fetch error:", error);

      showFormMessage(
        "jar-message",
        "Something went wrong while loading Jar posts",
        false,
      );
    });
}

//Function for opening the form to place the order
function openForm(distributorId, jarId, unit, price) {
  document.getElementById("orderForm").style.display = "block";
  document.getElementById("distributor_id").value = distributorId;
  document.getElementById("jar_id").value = jarId; //To know which jar
  document.getElementById("unit").value = unit;
  document.getElementById("price").value = price;
}

//Handling what happens after the order form is submitted
document.getElementById("orderForm").addEventListener("submit", (e) => {
  e.preventDefault();

  const form = document.getElementById("orderForm");

  if (!validateForm()) {
    document.getElementById("order-message").textContent =
      "Please fix errors before submitting.";
    return;
  }

  fetch("/Aqua-Jar/backend/api/placeorder.php", {
    method: "POST",
    body: new FormData(form),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        showFormMessage("order-message", data.message, true);
      } else {
        showFormMessage("order-message", data.message, false);
      }
    })
    .catch((error) => {
      // network / server crash / invalid JSON
      console.error("Fetch error:", error);

      showFormMessage(
        "order-message",
        "Something went wrong while ordering",
        false,
      );
    });
});

function validateForm() {
  let isValid = true;

  const quantity = document.getElementById("quantity");
  const delivery = document.getElementById("delivery_datetime");
  const location = document.getElementById("location");

  const qtyError = quantity.nextElementSibling;
  const deliveryError = delivery.nextElementSibling;
  const locationError = location.nextElementSibling;

  // clear errors
  qtyError.textContent = "";
  deliveryError.textContent = "";
  locationError.textContent = "";

  // Quantity
  if (quantity.value.trim() === "" || quantity.value <= 0) {
    qtyError.textContent = "Enter valid quantity";
    isValid = false;
  }

  // Delivery datetime
  if (delivery.value.trim() === "") {
    deliveryError.textContent = "Select delivery date/time";
    isValid = false;
  } else {
    const selected = new Date(delivery.value);
    const now = new Date();

    if (selected <= now) {
      deliveryError.textContent = "Must be future time";
      isValid = false;
    }
  }

  // Location
  if (location.value.trim().length < 3) {
    locationError.textContent = "Enter valid location";
    isValid = false;
  }

  return isValid;
}
//Main init function
function initCustomerDashboard() {
  const saved = localStorage.getItem("theme") || "light";
  applyTheme(saved === "dark");
  loadDashboardStats();
  loadJars();

  // Five min auto reload (polling)
  setInterval(() => {
    (loadDashboardStats(), loadJars());
  }, 5000);
}

function getLocalDateTime() {
  const now = new Date();
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
  return now.toISOString().slice(0, 16);
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Loaded");

  document.getElementById("delivery_datetime").min = getLocalDateTime();
  initCustomerDashboard();
});
