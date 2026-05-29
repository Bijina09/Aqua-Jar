//Handling the Jar posting
document.getElementById("postForm").addEventListener("submit", (e) => {
  e.preventDefault();
  const form = document.getElementById("postForm");

  if (!validateAddJar()) {
    document.getElementById("post-message").textContent =
      "Please fix errors before submitting.";
    return;
  }
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

function validateAddJar() {
  let isValid = true;

  const unit = document.getElementById("unit");
  const price = document.getElementById("price");
  const quantity = document.getElementById("quantity");

  const unitError = unit.nextElementSibling;
  const priceError = price.nextElementSibling;
  const qtyError = quantity.nextElementSibling;

  // clear errors
  unitError.textContent = "";
  priceError.textContent = "";
  qtyError.textContent = "";

  // Unit
  if (unit.value.trim() === "") {
    unitError.textContent = "Package type is required";
    return false;
  }

  //start with per, space+, digit+, space+, any of three(|), plural?, insensitive
  const unitPattern = /^per\s+\d+\s+(jar|pack|box)s?$/i;

  if (!unitPattern.test(unit)) {
    unitError.textContent = "Enter a valid package type (e.g., Per 3 Jars)";
    return false;
  }

  // Price
  if (price.value.trim() === "") {
    priceError.textContent = "Price is required";
    return false;
  }

  if (isNaN(price.value.trim())) {
    priceError.textContent = "Price must be a number";
    return false;
  }

  if (Number(price.value.trim()) <= 0) {
    priceError.textContent = "Price must be greater than 0";
    return false;
  }

  // Quantity
  if (quantity.value.trim() === "" || quantity.value <= 0) {
    qtyError.textContent = "Enter valid number of packs to order";
    isValid = false;
  }

  return isValid;
}

//Jar Details
function loadJarDetails() {
  fetch("/Aqua-Jar/backend/api/distributor/getJarDetails.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        const table = document.getElementById("jarDetailsTable");
        // Safety check - make sure element exists
        if (!table) {
          console.error("Element with id 'jarDetailsTable' not found");
          return;
        }
        table.innerHTML = "";

        data.data.forEach((item) => {
          // Calculate status from quantity
          let statusBadge = "";
          if (item.quantity > 10) {
            statusBadge = `<span class="badge badge-success">In Stock</span>`;
          } else if (item.quantity > 0) {
            statusBadge = `<span class="badge badge-warning">Low Stock</span>`;
          } else {
            statusBadge = `<span class="badge badge-danger">Out of Stock</span>`;
          }

          const row = `
            <tr>
              <td>${item.quantity}</td>
              <td>${item.price}</td>
              <td>${item.unit}</td>
              <td>${statusBadge}</td>
              <td><button onclick="editJar(${item.id})">Edit Jar</button></td>
            </tr>
          `;
          table.innerHTML += row;
        });
      } else {
        console.error(data.message);
        showFormMessage("jars-message", data.message, false);
      }
    })
    .catch((error) => {
      console.error("Fetch error:", error);
      showFormMessage("jars-message", "Something went wrong", false);
    });
}

let jarId = null;

function editJar(receivedJarId) {
  document.getElementById("editJarForm").style.display = "block";
  jarId = receivedJarId;
}

document.getElementById("editJarForm").onsubmit = (e) => {
  e.preventDefault();
  const price = document.getElementById("newPrice").value.trim();
  const quantity = document.getElementById("newQuantity").value.trim();

  if (!validateEditJar()) {
    document.getElementById("editJar-message").textContent =
      "Please fix errors before submitting.";
  }
  fetch("/Aqua-Jar/backend/api/distributor/editJar.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ jarId, price, quantity }),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        console.log(data.message);
        showFormMessage("editJar-message", data.message, true);
      } else {
        showFormMessage("editJar-message", data.message, false);
      }
    })
    .catch((error) => {
      console.error(error);
      showFormMessage("editJar-message", "Something went wrong", false);
    });
};

function validateEditJar() {
  let isValid = true;

  const price = document.getElementById("newPrice");
  const quantity = document.getElementById("newQuantity");

  const priceError = price.nextElementSibling;
  const qtyError = quantity.nextElementSibling;

  // clear errors
  priceError.textContent = "";
  qtyError.textContent = "";

  // Price
  if (price.value.trim() === "") {
    priceError.textContent = "Price is required";
    return false;
  }

  if (isNaN(price.value.trim())) {
    priceError.textContent = "Price must be a number";
    return false;
  }

  if (Number(price.value.trim()) <= 0) {
    priceError.textContent = "Price must be greater than 0";
    return false;
  }

  // Quantity
  if (quantity.value.trim() === "" || quantity.value <= 0) {
    qtyError.textContent = "Enter valid number of packs to order";
    isValid = false;
  }

  return isValid;
}
//Main init function
function initDistributorDashboard() {
  loadJarDetails();

  //Five min auto reload (polling)
  setInterval(() => {
    loadJarDetails();
  }, 5000);
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Loaded");
  initDistributorDashboard();
});
