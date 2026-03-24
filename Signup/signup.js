let currentStep = 1;

function goToStep(step) {
  // Init, handleNext, handleBack all call this function to show correct step, update buttons and progress
  currentStep = step;
  showStep(step);
  updateButton();
  updateProgress();
}
function init() {
  // on page load
  goToStep(currentStep);
}

function changeRole() {
  clearDistributorFields();
  updateProgress();
}
function handleNext() {
  // next button clicked
  const steps = getSteps(); //List [1,2,3]
  const currentIndex = steps.indexOf(currentStep); //Where I am on the list?
  const nextStep = steps[currentIndex + 1];

  if (!nextStep) {
    submitForm(); //Submit the form if there are no more steps
    return;
  }
  if (validateStep(currentStep)) {
    goToStep(nextStep);
  } else {
    // show error message
  }
}

function handleBack() {
  const steps = getSteps();
  const currentIndex = steps.indexOf(currentStep);
  const prevStep = steps[currentIndex - 1];
  goToStep(prevStep);
}

function showStep(stepToShow) {
  // show correct fieldset
  document.querySelectorAll("[data-step]").forEach((singleStep) => {
    singleStep.style.display =
      stepToShow === parseInt(singleStep.getAttribute("data-step"))
        ? "block"
        : "none";
  });
}

function clearDistributorFields() {
  document.getElementById("panNo").value = "";
  document.getElementById("supplierName").value = "";
  document.getElementById("supplierPanNo").value = "";
}

function updateButton() {
  const steps = getSteps();
  const isFirst = steps[0];
  const isLast = steps[steps.length - 1]; //length is a property not a fnc

  //First Step
  document.getElementById("prevBtn").style.display =
    currentStep === isFirst ? "none" : "block";

  //last Step
  document.getElementById("nextBtn").textContent =
    currentStep === isLast ? "Submit" : "Next";

  //Show Login link
  document.getElementById("login-link").style.display =
    currentStep == isFirst ? "block" : "none";
}

function updateProgress() {
  const steps = getSteps();
  const container = document.getElementById("steps-container"); //class-name returns a collection

  container.innerHTML = ""; //Emptying the container each time InnerHTML is a property not a function

  steps.forEach((step) => {
    const circle = document.createElement("span"); //Creating span element in memory

    circle.classList.add("steps"); //Adding base css class

    if (step === currentStep) {
      circle.classList.add("active");
    }
    if (step < currentStep) {
      circle.classList.add("finish");
    }

    container.appendChild(circle); //Actually putting it in the page
  });
}

function showError(errorElement, errorMessage) {
  const small = document.querySelector("." + errorElement);
  small.innerHTML = errorMessage;

  const input = small.closest(".form-group").querySelector(".input-boxes");

  if (input) {
    input.classList.add("input-error");
  }
}

function clearErrors() {
  document.querySelectorAll(".error").forEach((error) => {
    error.innerHTML = "";
  });
  document.querySelectorAll(".input-error").forEach((inputError) => {
    inputError.classList.remove("input-error");
  });
}

function validateStep(step) {
  clearErrors();
  // validate current step fields
  if (step === 1) {
    const name = document.getElementById("name").value.trim();
    const address = document.getElementById("address").value.trim();
    const phone = document.getElementById("phone").value.trim();
    if (name === "") {
      showError("name-error", "Name is required");
      return false;
    }
    if (address === "") {
      showError("address-error", "Address is required");
      return false;
    }
    if (phone === "") {
      showError("phone-error", "Phone is required");
      return false;
    }
    const phoneRegex = /^\d{10}$/;
    if (!phoneRegex.test(phone)) {
      showError("phone-error", "Please enter a valid 10-digit phone number");
      return false;
    }
    return true;
  } else if (step === 2) {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirmPassword = document
      .getElementById("ConfirmPassword")
      .value.trim();
    if (email === "") {
      showError("email-error", "Email is required");
      return false;
    }
    if (password === "") {
      showError("password-error", " Password is required");
      return false;
    }
    if (confirmPassword === "") {
      showError("confirm-password-error", "Confirm Password is required");
      return false;
    }
    if (password !== confirmPassword) {
      showError("confirm-password-error", "Passwords do not match");
      return false;
    }
    const emailRegex = /^[a-z0-9]+@(gmail|yahoo|hotmail)\.com$/;
    if (!emailRegex.test(email)) {
      showError("email-error", "Please enter a valid email address");
      return false;
    }
    return true;
  } else if (step === 3) {
    const panNo = document.getElementById("panNo").value.trim();
    const supplierName = document.getElementById("supplierName").value.trim();
    const supplierPAN = document.getElementById("supplierPanNo").value.trim();
    if (panNo === "") {
      showError("pan-error", "Pan No is required");
      return false;
    }
    if (supplierName === "") {
      showError("supplier-error", "Supplier Name is required");
      return false;
    }
    if (supplierPAN === "") {
      showError("supplier-pan-error", "Supplier Pan No is required");
      return false;
    }
    let panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
    if (!panRegex.test(panNo)) {
      showError("pan-error", "Please enter a valid PAN number");
      return false;
    }
    if (!panRegex.test(supplierPAN)) {
      showError("supplier-pan-error", "Please enter a valid PAN number");
      return false;
    }
    return true;
  }
}

function getSteps() {
  // return array based on role
  let SelectedRole = document.getElementById("role").value;
  if (SelectedRole === "distributor") {
    return [1, 2, 3];
  } else {
    return [1, 2];
  }
}

init();
