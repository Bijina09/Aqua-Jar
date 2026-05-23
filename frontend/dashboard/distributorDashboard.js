//Used by other functions to display UI message
function showFormMessage(id, message, isSuccess) {
  const msg = document.getElementById(id);
  msg.textContent = message;
  msg.className = "form-message " + (isSuccess ? "success" : "error");
}
function loadDashboardStats() {
  const distributorId = localStorage.getItem("distributor_id");

  fetch(`/Aqua-Jar/backend/api/distributor/dashboard.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id: distributorId }),
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
    .catch((error) => console.error("Fetch error:", error));
}

// Function for loading Recent Orders Activity
function loadActivityFeed() {
  const distributorId = localStorage.getItem("distributor_id");

  fetch(`/Aqua-Jar/backend/api/distributor/activity.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id: distributorId }),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log("FULL RESPONSE:", data);

      if (data.status === "success") {
        const feed = document.getElementById("activityFeed");
        feed.innerHTML = ""; // Clear existing

        data.orders.forEach((item) => {
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

//Function for loading the Distributor's Profile
function loadProfile() {
  const form = document.getElementById("form");

  fetch("/Aqua-Jar/backend/api/distributorProfile.php", {
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
        document.getElementById("panNo").value = data.panNo;
        document.getElementById("supplierName").value = data.supplierName;
        document.getElementById("supplierPanNo").value = data.supplierPanNo;
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
        "form-message",
        "Something went wrong while loading profile",
        false,
      );
    });
}

//Handling edit button
document.getElementById("editbtn").addEventListener("click", (e) => {
  document
    .querySelectorAll("#form input")
    .forEach((input) => (input.disabled = false));

  document.getElementById("savebtn").style.display = "block";
});

//Handling submit form after editing
document.getElementById("form").addEventListener("submit", (e) => {
  e.preventDefault();
  const form = document.getElementById("form");
  //console.log([...new FormData(form)]);
  fetch("/Aqua-Jar/backend/api/updateDistributor.php", {
    method: "POST",
    body: new FormData(form),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        console.log(data.message);
        showFormMessage("form-message", data.message, true);

        document
          .querySelectorAll("#form input")
          .forEach((i) => (i.disabled = true));

        document.getElementById("savebtn").style.display = "none";
      } else {
        showFormMessage("form-message", data.message, false);
      }
    })
    .catch((error) => {
      console.error(error);
      showFormMessage("form-message", "Something went wrong", false);
    });
});

//Handling the Jar posting
document.getElementById("postForm").addEventListener("submit", (e) => {
  e.preventDefault();
  const form = document.getElementById("postForm");
  // console.log([...new FormData(form)]);
  fetch("/Aqua-Jar/backend/api/postJar.php", {
    method: "POST",
    body: new FormData(form),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        console.log(data.message);
        showFormMessage("post-message", data.message, true);
      } else {
        showFormMessage("post-message", data.message, false);
      }
    })
    .catch((error) => {
      console.error(error);
      showFormMessage("post-message", "Something went wrong", false);
    });
});

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

//Function for displaying the Complaints from the Customer
function viewComplaints() {
  fetch("/Aqua-Jar/backend/api/viewComplaints.php")
    .then((res) => res.json())
    .then((data) => {
      console.log("FULL RESPONSE:", data);

      if (data.status === "success") {
        const table = document.getElementById("complaintsTable");
        table.innerHTML = ""; //Important to clear

        data.data.forEach((item) => {
          //Setting actionCell value based on status
          let actionCell = "";
          if (item.status === "OPEN") {
            // Template literals (backticks ` `) in JavaScript
            actionCell = `
                <button onclick="resolveComplaint(${item.complaint_id})">Resolve Complaint</button>
              `;
          } else if (item.status === "resolved") {
            actionCell = `<span class="badge badge-success">Resolved</span>`;
          }
          console.log(item.image);
          // Template literals (backticks ` `) in JavaScript
          const row = `
          <tr>
            <td>${item.customer_id}</td>
            <td>${item.customer_name}</td>
            <td>${item.order_id}</td>
            <td>${item.message}</td>
            <td><img src="${item.image}" alt="jar_image" class="jar-img""/></td>
            <td class = "status-cell"><span class="badge badge-${item.status}">${item.status}</span></td>
            <td class = "action-cell">${actionCell}</td>
          </tr>
          `;
          table.innerHTML += row;
        });
      } else {
        // backend returned error (like "Unauthorized", "Empty")
        console.error(data.message);
        showFormMessage("complaintsDistributor-message", data.message, false);
      }
    })
    .catch((error) => {
      // network / server crash / invalid JSON
      console.error("Fetch error:", error);

      showFormMessage(
        "complaintsDistributor-message",
        "Something went wrong while loading Complaints",
        false,
      );
    });
}

//Global to let complaintId be accessed
let complaintId = "";

//Resolves the complaint
function resolveComplaint(complaint_id) {
  document.getElementById("resolveForm").style.display = "block";
  complaintId = complaint_id;
}

document.getElementById("resolveForm").onsubmit = (e) => {
  e.preventDefault();

  const reply = document.getElementById("reply").value.trim();
  fetch("/Aqua-Jar/backend/api/resolveComplaint.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ complaint_id: complaintId, reply }),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        console.log(data.message);
        showFormMessage("resolve-message", data.message, true);
        loadOrders();
      } else {
        showFormMessage("resolve-message", data.message, false);
      }
    })
    .catch((error) => {
      console.error(error);
      showFormMessage("resolve-message", "Something went wrong", false);
    });
};

//Main init function
function initDistributorDashboard() {
  loadDashboardStats();
  loadProfile();
  loadOrders();
  viewComplaints();

  //Five min auto reload (polling)
  setInterval(() => {
    (loadDashboardStats(), loadOrders(), viewComplaints());
  }, 5000);
}

document.addEventListener("DOMContentLoaded", initDistributorDashboard());
