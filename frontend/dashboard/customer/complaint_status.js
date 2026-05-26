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
function viewComplaintStatus() {
  fetch("/Aqua-Jar/backend/api/customer/viewComplaintStatus.php")
    .then((res) => res.json())
    .then((data) => {
      console.log("FULL RESPONSE:", data);

      if (data.status === "success") {
        const table = document.getElementById("complaintStatusTable");

        table.innerHTML = ""; // IMPORTANT

        data.data.forEach((item) => {
          // Template literals (backticks ` `) in JavaScript

          const row = `
            <tr>
              <td>${item.distributor_name}</td>
              <td>${item.order_id}</td>
              <td>${item.message}</td>
              <td>
                ${
                  item.image
                    ? `<img src="${item.image}" alt="jar_image" class="jar-img"/>`
                    : `<span>No Image</span>`
                }
               </td>
              <td>${item.reply}</td>
              <td>${item.status}</td>
              <td>${item.submitted_at}</td>
              <td>${item.resolved_at || "Pending"}</td>
            </tr>
            `;

          table.innerHTML += row;
        });
      } else {
        // backend returned error (like "Unauthorized", "Empty")
        console.error(data.message);
        showFormMessage("complaintStatus-message", data.message, false);
      }
    })
    .catch((error) => {
      // network / server crash / invalid JSON
      console.error("Fetch error:", error);

      showFormMessage(
        "complaintStatus-message",
        "Something went wrong while loading complaint details",
        false,
      );
    });
}

//Main init function
function initCustomerDashboard() {
  const saved = localStorage.getItem("theme") || "light";
  applyTheme(saved === "dark");
  viewComplaintStatus();

  // Five min auto reload (polling)
  // setInterval(() => {
  //   (loadMyOrders());
  // }, 5000);
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Loaded");
  initCustomerDashboard();
});
