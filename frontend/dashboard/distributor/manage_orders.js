//Function for loading the Orders from the Customer
function loadOrders() {
  fetch("/Aqua-Jar/backend/api/availableOrders.php")
    .then((res) => res.json())
    .then((data) => {
      console.log("FULL RESPONSE:", data);

      if (data.status === "success") {
        const table = document.getElementById("orderTable");
        table.innerHTML = ""; //Important to clear

        data.data.forEach((item) => {
          //Setting actionCell value based on status
          let actionCell = "";
          if (item.status === "pending") {
            // Template literals (backticks ` `) in JavaScript
            actionCell = `
                <button onclick="updateStatus(${item.order_id}, 'accepted')">Accept</button>
                <button onclick="updateStatus(${item.order_id}, 'rejected')">Reject</button>
              `;
          } else if (item.status === "accepted") {
            actionCell = `<button onclick="assignDriver(${item.order_id})">Assign Driver</button>`;
          } else if (item.status === "out for delivery") {
            actionCell = `<button onclick="markDelivered(${item.order_id}, 'delivered')">Mark Delivered</button>`;
          } else if (item.status === "delivered") {
            actionCell = `<span class="badge badge-success">Completed</span>`;
          }

          // Template literals (backticks ` `) in JavaScript
          const row = `
          <tr>
            <td>${item.customer_name}</td>
            <td>${item.quantity}</td>
            <td>${item.location}</td>
            <td>${item.delivery_datetime}</td>
            <td class = "status-cell"><span class="badge badge-${item.status}">${item.status}</span></td>
            <td class = "action-cell">${actionCell}</td>
          </tr>
          `;
          table.innerHTML += row;
        });
      } else {
        // backend returned error (like "Unauthorized", "Empty")
        console.error(data.message);
        showFormMessage("order-message", data.message, false);
      }
    })
    .catch((error) => {
      // network / server crash / invalid JSON
      console.error("Fetch error:", error);

      showFormMessage(
        "order-message",
        "Something went wrong while loading Orders",
        false,
      );
    });
}

//Function for updating the status (calling API)
function updateStatus(orderId, status) {
  fetch("/Aqua-Jar/backend/api/updateStatus.php", {
    method: "POST",
    body: JSON.stringify({ orderId, status }),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        console.log(data.message);
        showFormMessage("order-message", data.message, true);
        loadOrders();
      } else {
        showFormMessage("order-message", data.message, false);
      }
    })
    .catch((error) => {
      console.error(error);
      showFormMessage("order-message", "Something went wrong", false);
    });
}

//Global to let the onsubmit access orderId
let selectedOrderId = null;

//Assigning the Driver details
function assignDriver(orderId) {
  selectedOrderId = orderId;
  document.getElementById("driverForm").style.display = "block";
  const form = document.getElementById("driverForm");
}

//Driver Form submition logic
document.getElementById("driverForm").onsubmit = (e) => {
  e.preventDefault();

  const driverName = document.getElementById("driverName").value;
  const driverContact = document.getElementById("driverContact").value;

  fetch("/Aqua-Jar/backend/api/assignDriver.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      orderId: selectedOrderId,
      driverName,
      driverContact,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        console.log(data.message);
        showFormMessage("driver-message", data.message, true);
        e.target.reset();
        e.target.style.display = "none";
        loadOrders(); // IMPORTANT
      } else {
        showFormMessage("driver-message", data.message, false);
      }
    })
    .catch((error) => {
      console.error(error);
      showFormMessage("driver-message", "Something went wrong", false);
    });
};

//For Marking status delivered and adding delivered_at (time)
function markDelivered(orderId, status) {
  fetch("/Aqua-Jar/backend/api/markDelivered.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ orderId, status }),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        console.log(data.message);
        showFormMessage("driver-message", data.message, true);
        loadOrders();
      } else {
        showFormMessage("driver-message", data.message, false);
      }
    })
    .catch((error) => {
      console.error(error);
      showFormMessage("driver-message", "Something went wrong", false);
    });
}

//Main init function
function initDistributorDashboard() {
  loadOrders();

  //Five min auto reload (polling)
  setInterval(() => {
    loadOrders();
  }, 5000);
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Loaded");
  initDistributorDashboard();
});
