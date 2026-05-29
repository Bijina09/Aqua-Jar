//Function for loading the Distributor's Profile
function loadProfile() {
  const form = document.getElementById("form-box");

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
        document.getElementById("serviceArea").value = data.serviceArea;
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
    .querySelectorAll("#form-box input")
    .forEach((input) => (input.disabled = false));

  document.getElementById("savebtn").style.display = "block";
});

//Handling submit form after editing
document.getElementById("form-box").addEventListener("submit", (e) => {
  e.preventDefault();
  const form = document.getElementById("form-box");

  if (!validateProfile()) {
    document.getElementById("profile-message").textContent =
      "Please fix errors before submitting.";
    return;
  }
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
        showFormMessage("profile-message", data.message, true);

        document
          .querySelectorAll("#form input")
          .forEach((i) => (i.disabled = true));

        document.getElementById("savebtn").style.display = "none";
      } else {
        showFormMessage("profile-message", data.message, false);
      }
    })
    .catch((error) => {
      console.error(error);
      showFormMessage("profile-message", "Something went wrong", false);
    });
});

function validateProfile() {
  //Input fields
  const name = document.getElementById("name");
  const address = document.getElementById("address");
  const phone = document.getElementById("phone");
  const serviceArea = document.getElementById("serviceArea");
  const supplierName = document.getElementById("supplierName");

  const nameValue = name.value.trim();
  const addressValue = address.value.trim();
  const phoneValue = phone.value.trim();
  const serviceAreaValue = serviceArea.value.trim();
  const supplierNameValue = supplierName.value.trim();

  const nameError = name.nextElementSibling;
  const addressError = address.nextElementSibling;
  const phoneError = phone.nextElementSibling;
  const serviceAreaError = serviceArea.nextElementSibling;
  const supplierNameError = supplierName.nextElementSibling;

  let isValid = true;

  // Clear previous errors
  nameError.textContent = "";
  addressError.textContent = "";
  phoneError.textContent = "";
  serviceAreaError.textContent = "";
  supplierNameError.textContent = "";

  // Name
  if (nameValue === "") {
    nameError.textContent = "Name is required";
    isValid = false;
  }

  // Address
  if (addressValue === "") {
    addressError.textContent = "Address is required";
    isValid = false;
  }

  // Phone required
  if (phoneValue === "") {
    phoneError.textContent = "Phone is required";
    isValid = false;
  }
  // Phone regex (10 digits only)
  const phoneRegex = /^\d{10}$/;

  if (!phoneRegex.test(phoneValue)) {
    phoneError.textContent = "Enter valid 10-digit phone number";
    isValid = false;
  }

  // Service Area required
  if (serviceAreaValue === "") {
    serviceAreaError.textContent = "Service Area is required";
    isValid = false;
  }

  // supplier required
  if (supplierNameValue === "") {
    supplierNameError.textContent = "Supplier Name is required";
    isValid = false;
  }

  return isValid;
}

//Main init function
function initDistributorDashboard() {
  loadProfile();
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Loaded");
  initDistributorDashboard();
});
