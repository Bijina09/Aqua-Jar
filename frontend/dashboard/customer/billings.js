const ORDER_ID = window.__ORDER_ID__ || 0; // Set via: <script>window.__ORDER_ID__ = <?= $order_id ?>;</script>

// ── Theme ────────────────────────────────────────────────
function applyTheme(dark) {
  document.documentElement.setAttribute("data-theme", dark ? "dark" : "light");
  document.getElementById("theme-toggle-btn").textContent = dark ? "☀️" : "🌙";
  localStorage.setItem("theme", dark ? "dark" : "light");
}
function toggleTheme() {
  applyTheme(document.documentElement.getAttribute("data-theme") !== "dark");
}

// ── Status pill helper ───────────────────────────────────
function statusClass(s) {
  const map = {
    delivered: "status-delivered",
    pending: "status-pending",
    cancelled: "status-cancelled",
  };
  return map[s.toLowerCase()] || "status-delivered";
}

// ── Render invoice ───────────────────────────────────────
function renderInvoice(d) {
  const grandTotal = d.total_price;
  const invNo = "INV-" + String(d.order_id).padStart(4, "0");
  const packageType = d.package_type; // "Per 3 Jars"
  const quantity = d.packs_ordered; // 2 packs ordered

  let jarsPerPack = 1;

  const match = packageType.match(/\d+/);

  if (match) {
    jarsPerPack = parseInt(match[0]);
  }

  const totalJars = jarsPerPack * quantity;

  document.getElementById("invoice-body").innerHTML = `
    <div class="inv-header">
      <div>
        <div class="inv-brand-name">Aqua Jar</div>
        <div class="inv-brand-sub">Water Supply System</div>
      </div>
      <div class="inv-badge-wrap">
        <div class="inv-no">${invNo}</div>
        <div class="status-pill ${statusClass(d.status)}">${d.status}</div>
      </div>
    </div>

    <div class="inv-meta">
      <div>
        <span class="meta-label">Order date</span>
        <span class="meta-value">${d.order_date}</span>
      </div>
      <div>
        <span class="meta-label">Delivery time</span>
        <span class="meta-value small">${d.delivery_datetime ?? "—"}</span>
      </div>
      <div>
        <span class="meta-label">Delivery location</span>
        <span class="meta-value small">${d.delivery_location}</span>
      </div>
      <div>
        <span class="meta-label">Invoice no.</span>
        <span class="meta-value" style="font-family:'DM Mono',monospace">${invNo}</span>
      </div>
    </div>

    <div class="inv-parties">
      <div>
        <div class="party-role">Customer</div>
        <div class="party-name">${d.customer_name}</div>
        <div class="party-detail"><i class="ti ti-map-pin"></i> ${d.delivery_location}</div>
      </div>
      <div>
        <div class="party-role">Distributor</div>
        <div class="party-name">${d.distributor_name}</div>
        <div class="party-detail"><i class="ti ti-map-pin"></i> ${d.distributor_location ?? "—"}</div>
      </div>
    </div>

    <div class="inv-items">
      <div class="items-heading">Order details</div>
      <table class="items-table">
        <thead>
          <tr>
            <th>Item</th>
            <th>Package type</th>
            <th>Unit price</th>
            <th>Packs</th>
            <th>Jars</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="item-name">Aqua Jar</div>
              <div class="item-sub">Drinking water jar</div>
            </td>
            <td>${d.package_type}</td>
            <td>Rs. ${d.price_per_pack}</td>
            <td>${d.packs_ordered}</td>
            <td>${totalJars ?? d.quantity}</td>
            <td style="font-weight:500;font-family:'DM Mono',monospace">Rs. ${d.total_price}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="inv-total">
      <div class="total-box">
        <div class="total-row"><span>Subtotal</span><span>Rs. ${d.total_price}</span></div>
        <div class="total-row"><span>Delivery charge</span><span>Rs. 0</span></div>
        <div class="total-row grand"><span>Grand total</span><span>Rs. ${grandTotal}</span></div>
      </div>
    </div>

    <div class="inv-footer">
      <div class="footer-note">Thank you for choosing Aqua Jar</div>
      <div class="footer-sys">System generated invoice</div>
    </div>
  `;
}

// ── Load invoice data ────────────────────────────────────
function loadInvoice() {
  if (!ORDER_ID) {
    document.getElementById("invoice-body").innerHTML =
      '<div class="state-msg">No order specified.</div>';
    return;
  }

  fetch(`/Aqua-Jar/backend/api/customer/getBill.php?order_id=${ORDER_ID}`)
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        renderInvoice(data.data);
      } else {
        document.getElementById("invoice-body").innerHTML =
          `<div class="state-msg">${data.message}</div>`;
      }
    })
    .catch(() => {
      document.getElementById("invoice-body").innerHTML =
        '<div class="state-msg">Could not load invoice. Please try again.</div>';
    });
}

// ── PDF export ───────────────────────────────────────────
function exportPDF() {
  const el = document.getElementById("invoice-body");
  const invNo = el.querySelector(".inv-no")?.textContent?.trim() || "invoice";
  html2pdf()
    .set({
      margin: [10, 10, 10, 10],
      filename: `${invNo}-AquaJar.pdf`,
      image: { type: "jpeg", quality: 0.98 },
      html2canvas: { scale: 2, useCORS: true },
      jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
    })
    .from(el)
    .save();
}

// ── Init ─────────────────────────────────────────────────
document.addEventListener("DOMContentLoaded", () => {
  const saved = localStorage.getItem("theme") || "light";
  applyTheme(saved === "dark");
  loadInvoice();
});
