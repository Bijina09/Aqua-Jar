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

      showFormMessage("Something went wrong while loading profile", false);
    });
}

loadProfile();
loadJars();

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
      showFormMessage("Something went wrong", false);
    });
});

function loadJars() {
  fetch("/Aqua-Jar/backend/api/browseJars.php")
    .then((res) => res.json())
    .then((data) => {
      console.log("FULL RESPONSE:", data);
      if (data.status === "success") {
        const table = document.getElementById("jarTable");
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

      showFormMessage("Something went wrong while loading Jar posts", false);
    });
}
function openForm(distributorId) {
  document.getElementById("orderForm").style.display = "block";
  document.getElementById("distributor_id").value = distributorId;
}
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

      showFormMessage("Something went wrong while ordering", false);
    });
});
