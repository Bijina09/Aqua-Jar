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
