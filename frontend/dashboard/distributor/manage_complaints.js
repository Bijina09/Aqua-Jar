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
            <td>${item.customer_name}</td>
            <td>${item.order_id}</td>
            <td>${item.message}</td>
            <td>
              ${
                item.image
                  ? `<img src="${item.image}" alt="jar_image" class="jar-img"/>`
                  : `<span>No Image</span>`
              }
            </td>
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
  viewComplaints();

  //Five min auto reload (polling)
  setInterval(() => {
    viewComplaints();
  }, 5000);
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Loaded");
  initDistributorDashboard();
});
