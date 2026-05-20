//Like a helper function to show messages
function showFormMessage(id, message, isSuccess) {
  const msg = document.getElementById(id);
  msg.textContent = message;
  msg.className = "form-message " + (isSuccess ? "success" : "error");
}

//This is where is load Customer Profile
function loadProfile() {
  const form = document.getElementById("form");

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
        "form-message",
        "Something went wrong while loading profile",
        false,
      );
    });
}

//Handling editing profile
document.getElementById("editbtn").addEventListener("click", (e) => {
  document
    .querySelectorAll("#form input")
    .forEach((input) => (input.disabled = false));

  document.getElementById("savebtn").style.display = "block";
});

//Handling the update submit button
document.getElementById("form").addEventListener("submit", (e) => {
  e.preventDefault();
  const form = document.getElementById("form");
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
            <td button onclick="openForm(${item.distributor_id})">Order</td>
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
function openForm(distributorId) {
  document.getElementById("orderForm").style.display = "block";
  document.getElementById("distributor_id").value = distributorId;
}

//Handling what happens after the order form is submitted
document.getElementById("orderForm").addEventListener("submit", (e) => {
  e.preventDefault();
  const form = document.getElementById("orderForm");

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

          const row = `
            <tr>
              <td>${item.distributor_name}</td>
              <td>${item.quantity}</td>
              <td>${item.status}</td>
              <td>${item.driver_name || "-"}</td>
              <td>${item.driver_contact || "-"}</td>
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
  loadProfile();
  loadJars();
  loadMyOrders();

  //Refreshing through polling every 5 mins
  setInterval(() => {
    loadJars();
    loadMyOrders();
  }, 5000);
}

//Calling the init function
document.addEventListener("DOMContentLoaded", initCustomerDashboard());
