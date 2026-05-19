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

      showFormMessage("Something went wrong while loading profile", false);
    });
}
loadProfile();
loadOrders();

document.getElementById("editbtn").addEventListener("click", (e) => {
  document
    .querySelectorAll("#form input")
    .forEach((input) => (input.disabled = false));

  document.getElementById("savebtn").style.display = "block";
});

function showFormMessage(id, message, isSuccess) {
  const msg = document.getElementById(id);
  msg.textContent = message;
  msg.className = "form-message " + (isSuccess ? "success" : "error");
}

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
      showFormMessage("form-message", "Something went wrong", false);
    });
});

function loadOrders() {
  fetch("/Aqua-Jar/backend/api/availableOrders.php")
    .then((res) => res.json())
    .then((data) => {
      console.log("FULL RESPONSE:", data);
      if (data.status === "success") {
        const table = document.getElementById("orderTable");
        table.innerHTML = "";
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
        showFormMessage("jar-message", data.message, false);
      }
    })
    .catch((error) => {
      // network / server crash / invalid JSON
      console.error("Fetch error:", error);

      showFormMessage("Something went wrong while loading Orders", false);
    });
}

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
      showFormMessage("form-message", "Something went wrong", false);
    });
}

//Global to let the onsubmit access orderId
let selectedOrderId = null;

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
      showFormMessage("form-message", "Something went wrong", false);
    });
};

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
      showFormMessage("form-message", "Something went wrong", false);
    });
}
