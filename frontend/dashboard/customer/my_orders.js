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

//Function for loading Customer's orders
function loadMyOrders() {
  fetch("/Aqua-Jar/backend/api/myOrders.php")
    .then((res) => res.json())
    .then((data) => {
      console.log("FULL RESPONSE:", data);

      if (data.status === "success") {
        const table = document.getElementById("myOrderTable");

        table.innerHTML = ""; // IMPORTANT

        data.data.forEach((item) => {
          // Template literals (backticks ` `) in JavaScript

          let badgeClass = "";

          if (item.status === "pending") badgeClass = "badge badge-pending";
          else if (item.status === "delivered")
            badgeClass = "badge badge-delivered";
          else if (item.status === "out for delivery")
            badgeClass = "badge badge-out";
          else if (item.status === "accepted")
            badgeClass = "badge badge-accepted";
          else if (item.status === "rejected")
            badgeClass = "badge badge-rejected";
          const row = `
            <tr>
              <td>${item.distributor_name}</td>
              <td>${item.quantity}</td>
              <td>${item.unit_price}</td>
              <td>${item.unit}</td>
              <td>${item.total_price}</td>
              <td><span class="${badgeClass}">${item.status}</span></td>
            </tr>
            `;

          table.innerHTML += row;
        });
      } else {
        // backend returned error (like "Unauthorized", "Empty")
        console.error(data.message);
        showFormMessage("myOrder-message", data.message, false);
      }
    })
    .catch((error) => {
      // network / server crash / invalid JSON
      console.error("Fetch error:", error);

      showFormMessage(
        "myOrder-message",
        "Something went wrong while loading order details",
        false,
      );
    });
}

//Main init function
function initCustomerDashboard() {
  const saved = localStorage.getItem("theme") || "light";
  applyTheme(saved === "dark");
  loadMyOrders();

  // Five min auto reload (polling)
  setInterval(() => {
    loadMyOrders();
  }, 5000);
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Loaded");
  initCustomerDashboard();
});
