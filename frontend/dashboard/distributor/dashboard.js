// function validateJarForm() {
//   const quantityInput = document.getElementById("quantity");

//   if (!quantityInput) return true; // safety check

//   let quantity = parseInt(quantityInput.value);

//   // Check empty or invalid number
//   if (isNaN(quantity) || quantity <= 0) {
//     alert("Quantity must be greater than 0");

//     quantityInput.focus();

//     return false;
//   }

//   return true;
// }

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

function loadDashboardStats() {
  fetch(`/Aqua-Jar/backend/api/distributor/getDashboardStats.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      if (data.status === "success") {
        document.getElementById("total-orders").textContent = data.total_orders;
        document.getElementById("pending-orders").textContent =
          data.pending_orders;
        document.getElementById("total-jars").textContent = data.total_jars;
        document.getElementById("open-complaints").textContent =
          data.open_complaints;
      } else {
        console.error(data.message);
      }
    })
    .catch((error) => {
      console.error("Fetch error:", error);
      showFormMessage("stats-message", "Something went wrong", false);
    });
}

// Function for loading Recent Orders Activity
function loadActivityFeed() {
  fetch(`/Aqua-Jar/backend/api/distributor/getActivity.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((res) => res.json())
    .then((data) => {
      console.log("FULL RESPONSE:", data);

      if (data.status === "success") {
        const feed = document.getElementById("activityFeed");
        feed.innerHTML = ""; // Clear existing

        data.data.forEach((item) => {
          // Template literal
          const activityItem = `
            <div class="activity-item">
              <div class="icon blue">📦</div>
              <div class="text">
                <div class="title">New Order</div>
                <div class="desc">Order received from ${item.customer_name}</div>
              </div>
              <div class="time">recent</div>
            </div>
          `;
          feed.innerHTML += activityItem;
        });
      } else {
        console.error(data.message);
        showFormMessage("activity-message", data.message, false);
      }
    })
    .catch((error) => {
      console.error("Fetch error:", error);
      showFormMessage("activity-message", "Something went wrong", false);
    });
}

//Main init function
function initDistributorDashboard() {
  const saved = localStorage.getItem("theme") || "light";
  applyTheme(saved === "dark");
  loadDashboardStats();
  loadActivityFeed();

  // Five min auto reload (polling)
  setInterval(() => {
    (loadDashboardStats(), loadActivityFeed());
  }, 5000);
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Loaded");
  initDistributorDashboard();
});
