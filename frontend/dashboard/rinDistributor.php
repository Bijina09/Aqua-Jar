<?php

    session_start();
    if(
        !isset($_SESSION['user_id']) ||
        $_SESSION['role'] !== "distributor"
        
    ) {
        header("Location: /Aqua-Jar/frontend/auth/login.html");
        exit;
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AQua Distributor Portal — Operations Center</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=JetBrains+Mono:wght@400;500;600&family=Nunito+Sans:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="rinDistributor.css" />
  </head>

  <body>
    <!-- ======= SIDEBAR ======= -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-logo">
        <div class="logo-icon">💧</div>
        <div class="logo-text-wrap">
          <span class="logo-name">AquaJar</span>
          <span class="logo-role">Distributor Portal</span>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle" title="Collapse">
          ‹
        </button>
      </div>

      <div class="sidebar-user">
        <div class="user-avatar">RB</div>
        <div class="user-info">
          <!-- ?= means ?php echo -->
          <strong><?= $_SESSION['name'] ?? 'Distributor' ?></strong>
          <span class="user-badge">Service Area · <?= $_SESSION['service_area'] ?? 'Not assigned' ?></span>
        </div>
      </div>

      <nav class="sidebar-nav">
        <div class="nav-section-label">Operations</div>
        <a class="nav-link active" href="#" data-page="dashboard">
          <span class="nav-icon">▦</span>
          <span class="nav-text">Dashboard</span>
          <span class="nav-count">Live</span>
        </a>
        <a class="nav-link" href="#" data-page="orders">
          <span class="nav-icon">📦</span>
          <span class="nav-text">Orders</span>
          <span class="nav-count">24</span>
        </a>
        <a class="nav-link" href="#" data-page="deliveries">
          <span class="nav-icon">🚚</span>
          <span class="nav-text">Deliveries</span>
          <span class="nav-count">12</span>
        </a>

        <!-- In case adding drivers -->
        <!-- <a class="nav-link" href="#" data-page="drivers">
          <span class="nav-icon">👷</span>
          <span class="nav-text">Drivers</span>
        </a> -->
        

        <div class="nav-section-label">Reports</div>
        <a class="nav-link" href="#" data-page="inventory">
          <span class="nav-icon">🗄</span>
          <span class="nav-text">Inventory</span>
        </a>
        <a class="nav-link" href="#" data-page="complaints">
          <span class="nav-icon">⚠</span>
          <span class="nav-text">Complaints</span>
          <span class="nav-count alert">2</span>
        </a>
        <a class="nav-link" href="#" data-page="billing">
          <span class="nav-icon">💳</span>
          <span class="nav-text">Billing</span>
        </a>

        <div class="nav-section-label">System</div>
        <a class="nav-link" href="#" data-page="settings">
          <span class="nav-icon">⚙</span>
          <span class="nav-text">Settings</span>
        </a>
      </nav>

      <div class="sidebar-footer">
        <div class="system-status">
          <div class="status-dot green"></div>
          <span>System Operational</span>
        </div>
      </div>
    </aside>

    <!-- ======= MAIN ======= -->
    <div class="main-wrap" id="mainWrap">
      <!-- TOPBAR -->
      <header class="topbar">
        <div class="topbar-left">
          <button class="mobile-menu-btn" id="mobileMenuBtn">☰</button>
          <div class="breadcrumb">
            <span class="breadcrumb-root">AquaJar</span>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-current">Dashboard</span>
          </div>
        </div>

        <div class="topbar-center">
          <div class="search-wrap">
            <span class="search-icon">⌕</span>
            <input
              type="text"
              placeholder="Search orders, drivers, stations..."
              class="topbar-search"
            />
            <span class="search-kbd">⌘K</span>
          </div>
        </div>

        <div class="topbar-right">
          <div class="live-clock" id="liveClock">--:--:--</div>
          <button class="icon-btn" title="Alerts">
            🔔
            <span class="icon-badge">2</span>
          </button>
        </div>
      </header>

      <!-- PAGE CONTENT -->
      <main class="content">
        <!-- ======= HERO ROW ======= -->
        <div class="page-header">
          <div>
            <h1 class="page-title">Operations Dashboard</h1>
            <p class="page-sub">
              <?= $_SESSION['service_area'] ?? 'Not assigned' ?> Distribution Area · <span id="todayDate"></span>
            </p>
          </div>
          <div class="page-header-actions">
            <select class="date-select">
              <option>Today</option>
              <option>This Week</option>
              <option>This Month</option>
            </select>
            <button class="btn btn-ghost">⬇ Export Report</button>
          </div>
        </div>

        <!-- ======= KPI CARDS ======= -->
        <div class="kpi-grid">
          <div class="kpi-card">
            <div class="kpi-top">
              <span class="kpi-label">Total Orders</span>
              <span class="kpi-icon blue-bg">📦</span>
            </div>
            <div class="kpi-value counter" data-target="1248">0</div>
            <div class="kpi-footer">
              <span class="kpi-trend up">↑ 12% vs yesterday</span>
            </div>
            <div class="kpi-bar">
              <div class="kpi-bar-fill blue" style="width: 78%"></div>
            </div>
          </div>

          <div class="kpi-card">
            <div class="kpi-top">
              <span class="kpi-label">Delivered</span>
              <span class="kpi-icon green-bg">✅</span>
            </div>
            <div class="kpi-value counter" data-target="1036">0</div>
            <div class="kpi-footer">
              <span class="kpi-trend up">↑ 83% completion rate</span>
            </div>
            <div class="kpi-bar">
              <div class="kpi-bar-fill green" style="width: 83%"></div>
            </div>
          </div>

          <div class="kpi-card">
            <div class="kpi-top">
              <span class="kpi-label">In Transit</span>
              <span class="kpi-icon orange-bg">🚚</span>
            </div>
            <div class="kpi-value counter" data-target="212">0</div>
            <div class="kpi-footer">
              <span class="kpi-trend neutral">37 active drivers</span>
            </div>
            <div class="kpi-bar">
              <div class="kpi-bar-fill orange" style="width: 17%"></div>
            </div>
          </div>

          <!-- Incase added payment -->
          <!-- <div class="kpi-card">
            <div class="kpi-top">
              <span class="kpi-label">Revenue Today</span>
              <span class="kpi-icon teal-bg">₨</span>
            </div>
            <div class="kpi-value">
              Rs. <span class="counter" data-target="224640">0</span>
            </div>
            <div class="kpi-footer">
              <span class="kpi-trend up">↑ 8.3% vs last week</span>
            </div>
            <div class="kpi-bar">
              <div class="kpi-bar-fill teal" style="width: 65%"></div>
            </div>
          </div> -->

          <div class="kpi-card">
            <div class="kpi-top">
              <span class="kpi-label">Open Complaints</span>
              <span class="kpi-icon red-bg">⚠</span>
            </div>
            <div class="kpi-value counter" data-target="2">0</div>
            <div class="kpi-footer">
              <span class="kpi-trend down">↓ 1 resolved today</span>
            </div>
            <div class="kpi-bar">
              <div class="kpi-bar-fill red" style="width: 8%"></div>
            </div>
          </div>

          <div class="kpi-card">
            <div class="kpi-top">
              <span class="kpi-label">Verified Stations</span>
              <span class="kpi-icon purple-bg">🏭</span>
            </div>
            <div class="kpi-value">
              <span class="counter" data-target="94">0</span>%
            </div>
            <div class="kpi-footer">
              <span class="kpi-trend up">↑ 2 pending review</span>
            </div>
            <div class="kpi-bar">
              <div class="kpi-bar-fill purple" style="width: 94%"></div>
            </div>
          </div>
        </div>

        <!-- ======= CHARTS ROW ======= -->
        <div class="grid-3-1">
          <!-- Weekly Chart -->
          <div class="panel">
            <div class="panel-header">
              <h3 class="panel-title">Weekly Delivery Volume</h3>
              <div class="panel-actions">
                <button class="tab active" onclick="switchTab(this)">
                  Deliveries
                </button>
                <button class="tab" onclick="switchTab(this)">Revenue</button>
              </div>
            </div>
            <div class="chart-area">
              <div class="chart-y-labels">
                <span>300</span>
                <span>225</span>
                <span>150</span>
                <span>75</span>
                <span>0</span>
              </div>
              <div class="chart-bars">
                <div class="chart-col">
                  <div class="chart-bar-wrap">
                    <div class="chart-bar" style="height: 52%" data-val="156">
                      <div class="bar-tooltip">156 jars</div>
                    </div>
                  </div>
                  <span class="chart-label">Mon</span>
                </div>
                <div class="chart-col">
                  <div class="chart-bar-wrap">
                    <div class="chart-bar" style="height: 73%" data-val="218">
                      <div class="bar-tooltip">218 jars</div>
                    </div>
                  </div>
                  <span class="chart-label">Tue</span>
                </div>
                <div class="chart-col">
                  <div class="chart-bar-wrap">
                    <div class="chart-bar" style="height: 63%" data-val="189">
                      <div class="bar-tooltip">189 jars</div>
                    </div>
                  </div>
                  <span class="chart-label">Wed</span>
                </div>
                <div class="chart-col">
                  <div class="chart-bar-wrap">
                    <div
                      class="chart-bar highlighted"
                      style="height: 90%"
                      data-val="270"
                    >
                      <div class="bar-tooltip">270 jars</div>
                    </div>
                  </div>
                  <span class="chart-label">Thu</span>
                </div>
                <div class="chart-col">
                  <div class="chart-bar-wrap">
                    <div class="chart-bar" style="height: 77%" data-val="230">
                      <div class="bar-tooltip">230 jars</div>
                    </div>
                  </div>
                  <span class="chart-label">Fri</span>
                </div>
                <div class="chart-col">
                  <div class="chart-bar-wrap">
                    <div class="chart-bar" style="height: 98%" data-val="295">
                      <div class="bar-tooltip">295 jars</div>
                    </div>
                  </div>
                  <span class="chart-label">Sat</span>
                </div>
                <div class="chart-col">
                  <div class="chart-bar-wrap">
                    <div
                      class="chart-bar today"
                      style="height: 83%"
                      data-val="248"
                    >
                      <div class="bar-tooltip">248 jars (today)</div>
                    </div>
                  </div>
                  <span class="chart-label today-label">Sun ·</span>
                </div>
              </div>
            </div>
            <div class="chart-legend">
              <span class="legend-dot blue-dot"></span> Completed
              <span
                class="legend-dot orange-dot"
                style="margin-left: 16px"
              ></span>
              In Transit
              <span
                class="legend-dot teal-dot"
                style="margin-left: 16px"
              ></span>
              Today
            </div>
          </div>

          <!-- Zone Breakdown -->
          <div class="panel">
            <div class="panel-header">
              <h3 class="panel-title">Zone Breakdown</h3>
            </div>
            <div class="zone-list">
              <div class="zone-item">
                <div class="zone-info">
                  <span class="zone-name">Lalitpur</span>
                  <span class="zone-val">428</span>
                </div>
                <div class="zone-bar-wrap">
                  <div class="zone-bar" style="width: 86%"></div>
                </div>
                <span class="zone-pct">86%</span>
              </div>
              <div class="zone-item">
                <div class="zone-info">
                  <span class="zone-name">Baneshwor</span>
                  <span class="zone-val">312</span>
                </div>
                <div class="zone-bar-wrap">
                  <div class="zone-bar amber" style="width: 63%"></div>
                </div>
                <span class="zone-pct">63%</span>
              </div>
              <div class="zone-item">
                <div class="zone-info">
                  <span class="zone-name">Bhaktapur</span>
                  <span class="zone-val">285</span>
                </div>
                <div class="zone-bar-wrap">
                  <div class="zone-bar green" style="width: 57%"></div>
                </div>
                <span class="zone-pct">57%</span>
              </div>
              <div class="zone-item">
                <div class="zone-info">
                  <span class="zone-name">Kirtipur</span>
                  <span class="zone-val">143</span>
                </div>
                <div class="zone-bar-wrap">
                  <div class="zone-bar purple" style="width: 29%"></div>
                </div>
                <span class="zone-pct">29%</span>
              </div>
              <div class="zone-item">
                <div class="zone-info">
                  <span class="zone-name">Thimi</span>
                  <span class="zone-val">80</span>
                </div>
                <div class="zone-bar-wrap">
                  <div class="zone-bar red" style="width: 16%"></div>
                </div>
                <span class="zone-pct">16%</span>
              </div>
            </div>
          </div>
        </div>

        <!-- ======= TABLES ROW ======= -->
        <div class="grid-2-1">
          <!-- Live Deliveries Table -->
          <div class="panel">
            <div class="panel-header">
              <h3 class="panel-title">Live Delivery Feed</h3>
              <div class="panel-actions">
                <div class="live-indicator">
                  <span class="live-dot"></span> LIVE
                </div>
                <button class="btn-text">View All →</button>
              </div>
            </div>
            <div class="table-scroll">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Jar ID</th>
                    <th>Driver</th>
                    <th>Route</th>
                    <th>Station</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="mono">JAR-4821</td>
                    <td>
                      <div class="driver-cell">
                        <div class="mini-avatar">RT</div>
                        Ramesh T.
                      </div>
                    </td>
                    <td>Baneshwor → Koteshwor</td>
                    <td>Eco Pure Station</td>
                    <td class="mono">09:42</td>
                    <td><span class="badge delivered">Delivered</span></td>
                    <td><button class="row-btn">›</button></td>
                  </tr>
                  <tr class="row-highlight">
                    <td class="mono">JAR-4822</td>
                    <td>
                      <div class="driver-cell">
                        <div class="mini-avatar orange">BS</div>
                        Bikash S.
                      </div>
                    </td>
                    <td>Lalitpur → Jawalakhel</td>
                    <td>AQua Hub South</td>
                    <td class="mono">10:15</td>
                    <td><span class="badge transit">In Transit</span></td>
                    <td><button class="row-btn">›</button></td>
                  </tr>
                  <tr>
                    <td class="mono">JAR-4823</td>
                    <td>
                      <div class="driver-cell">
                        <div class="mini-avatar green">SR</div>
                        Suman R.
                      </div>
                    </td>
                    <td>Bhaktapur → Suryabinayak</td>
                    <td>Bhaktapur Eco</td>
                    <td class="mono">10:03</td>
                    <td><span class="badge delivered">Delivered</span></td>
                    <td><button class="row-btn">›</button></td>
                  </tr>
                  <tr>
                    <td class="mono">JAR-4824</td>
                    <td>
                      <div class="driver-cell">
                        <div class="mini-avatar purple">KP</div>
                        Krishna P.
                      </div>
                    </td>
                    <td>Kirtipur → Balkhu</td>
                    <td>Kirtipur Station</td>
                    <td class="mono">10:28</td>
                    <td><span class="badge transit">In Transit</span></td>
                    <td><button class="row-btn">›</button></td>
                  </tr>
                  <tr>
                    <td class="mono">JAR-4825</td>
                    <td>
                      <div class="driver-cell">
                        <div class="mini-avatar red">AM</div>
                        Anil M.
                      </div>
                    </td>
                    <td>Patan → Lagankhel</td>
                    <td>Patan Pure</td>
                    <td class="mono">—</td>
                    <td><span class="badge pending">Pending</span></td>
                    <td><button class="row-btn">›</button></td>
                  </tr>
                  <tr>
                    <td class="mono">JAR-4826</td>
                    <td>
                      <div class="driver-cell">
                        <div class="mini-avatar">DT</div>
                        Dinesh T.
                      </div>
                    </td>
                    <td>Thimi → Lokanthali</td>
                    <td>East Station</td>
                    <td class="mono">09:55</td>
                    <td><span class="badge delivered">Delivered</span></td>
                    <td><button class="row-btn">›</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Right Column -->
          <div class="right-col">
            <!-- Top Drivers -->
            <div class="panel">
              <div class="panel-header">
                <h3 class="panel-title">Top Drivers</h3>
                <button class="btn-text">Manage →</button>
              </div>
              <div class="driver-list">
                <div class="driver-row">
                  <span class="rank gold">#1</span>
                  <div class="mini-avatar lg">RT</div>
                  <div class="driver-info">
                    <strong>Ramesh Tamang</strong>
                    <span>143 deliveries · DRV-021</span>
                  </div>
                  <div class="driver-rating">
                    <span class="stars">★★★★★</span>
                    <span class="rating-val">4.9</span>
                  </div>
                </div>
                <div class="driver-row">
                  <span class="rank silver">#2</span>
                  <div class="mini-avatar lg orange">BS</div>
                  <div class="driver-info">
                    <strong>Bikash Shrestha</strong>
                    <span>98 deliveries · DRV-042</span>
                  </div>
                  <div class="driver-rating">
                    <span class="stars">★★★★☆</span>
                    <span class="rating-val">4.7</span>
                  </div>
                </div>
                <div class="driver-row">
                  <span class="rank bronze">#3</span>
                  <div class="mini-avatar lg green">SR</div>
                  <div class="driver-info">
                    <strong>Suman Rai</strong>
                    <span>84 deliveries · DRV-037</span>
                  </div>
                  <div class="driver-rating">
                    <span class="stars">★★★★☆</span>
                    <span class="rating-val">4.6</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Recent Activity -->
            <div class="panel">
              <div class="panel-header">
                <h3 class="panel-title">Activity Log</h3>
                <div class="live-indicator">
                  <span class="live-dot"></span> LIVE
                </div>
              </div>
              <div class="activity-log" id="activityLog">
                <div class="log-item">
                  <div class="log-dot green"></div>
                  <div class="log-body">
                    <p><strong>JAR-4821 Delivered</strong></p>
                    <span>Ramesh T. · Baneshwor · 09:42 AM</span>
                  </div>
                </div>
                <div class="log-item">
                  <div class="log-dot blue"></div>
                  <div class="log-body">
                    <p><strong>New Order Received</strong></p>
                    <span>Customer #2841 · Patan · 09:38 AM</span>
                  </div>
                </div>
                <div class="log-item">
                  <div class="log-dot orange"></div>
                  <div class="log-body">
                    <p><strong>Driver Dispatched</strong></p>
                    <span>DRV-055 registered · 09:30 AM</span>
                  </div>
                </div>
                <div class="log-item">
                  <div class="log-dot teal"></div>
                  <div class="log-body">
                    <p><strong>Station Verified</strong></p>
                    <span>Bhaktapur Eco Water · 09:15 AM</span>
                  </div>
                </div>
                <div class="log-item">
                  <div class="log-dot red"></div>
                  <div class="log-body">
                    <p><strong>Complaint Filed</strong></p>
                    <span>Customer #1932 · Late delivery · 08:52 AM</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ======= INVENTORY + STATIONS ROW ======= -->
        <div class="grid-2">
          <!-- Inventory Status -->
          <div class="panel">
            <div class="panel-header">
              <h3 class="panel-title">Inventory Status</h3>
              <button class="btn btn-ghost sm">+ Restock</button>
            </div>
            <div class="inventory-grid">
              <div class="inv-item">
                <div class="inv-icon">💧</div>
                <div class="inv-info">
                  <strong>20L Water Jars</strong>
                  <span>AQua Purified</span>
                </div>
                <div class="inv-stock good">
                  <span class="inv-num">348</span>
                  <span class="inv-label">In Stock</span>
                </div>
              </div>
              <div class="inv-item">
                <div class="inv-icon">🔵</div>
                <div class="inv-info">
                  <strong>Empty Returns</strong>
                  <span>Awaiting Refill</span>
                </div>
                <div class="inv-stock warn">
                  <span class="inv-num">82</span>
                  <span class="inv-label">Pending</span>
                </div>
              </div>
              <div class="inv-item">
                <div class="inv-icon">🏷</div>
                <div class="inv-info">
                  <strong>QR-Tagged Jars</strong>
                  <span>Traceable Units</span>
                </div>
                <div class="inv-stock good">
                  <span class="inv-num">430</span>
                  <span class="inv-label">Active</span>
                </div>
              </div>
              <div class="inv-item">
                <div class="inv-icon">⚗</div>
                <div class="inv-info">
                  <strong>TDS Test Kits</strong>
                  <span>Quality Check</span>
                </div>
                <div class="inv-stock low">
                  <span class="inv-num">7</span>
                  <span class="inv-label">Low Stock</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Station Status -->
          <div class="panel">
            <div class="panel-header">
              <h3 class="panel-title">Station Status</h3>
              <button class="btn-text">View All →</button>
            </div>
            <div class="station-list">
              <div class="station-row">
                <div class="station-info">
                  <div class="station-dot online"></div>
                  <div>
                    <strong>Eco Pure Station</strong>
                    <span>Baneshwor · Capacity 82%</span>
                  </div>
                </div>
                <span class="badge delivered">Verified</span>
              </div>
              <div class="station-row">
                <div class="station-info">
                  <div class="station-dot online"></div>
                  <div>
                    <strong>AQua Hub South</strong>
                    <span>Lalitpur · Capacity 71%</span>
                  </div>
                </div>
                <span class="badge delivered">Verified</span>
              </div>
              <div class="station-row">
                <div class="station-info">
                  <div class="station-dot online"></div>
                  <div>
                    <strong>Bhaktapur Eco Water</strong>
                    <span>Bhaktapur · Capacity 65%</span>
                  </div>
                </div>
                <span class="badge transit">New</span>
              </div>
              <div class="station-row">
                <div class="station-info">
                  <div class="station-dot warn"></div>
                  <div>
                    <strong>Kirtipur Station</strong>
                    <span>Kirtipur · Capacity 33%</span>
                  </div>
                </div>
                <span class="badge pending">Review</span>
              </div>
              <div class="station-row">
                <div class="station-info">
                  <div class="station-dot offline"></div>
                  <div>
                    <strong>East Station</strong>
                    <span>Thimi · Offline for maintenance</span>
                  </div>
                </div>
                <span class="badge alert-badge">Offline</span>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- ======= NEW DELIVERY MODAL ======= -->
    <div class="modal-overlay" id="modalOverlay">
      <div class="modal">
        <div class="modal-header">
          <h3>New Delivery Order</h3>
          <button class="modal-close" id="modalClose">✕</button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group">
              <label>Customer Name</label>
              <input type="text" placeholder="e.g. Sunita Pandey" />
            </div>
            <div class="form-group">
              <label>Phone Number</label>
              <input type="text" placeholder="+977-98XXXXXXXX" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Delivery Zone</label>
              <select>
                <option>Lalitpur</option>
                <option>Baneshwor</option>
                <option>Bhaktapur</option>
                <option>Kirtipur</option>
                <option>Thimi</option>
              </select>
            </div>
            <div class="form-group">
              <label>Assign Driver</label>
              <select>
                <option>Ramesh Tamang (DRV-021)</option>
                <option>Bikash Shrestha (DRV-042)</option>
                <option>Suman Rai (DRV-037)</option>
                <option>Krishna Poudel (DRV-055)</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Delivery Address</label>
            <input type="text" placeholder="Street, Ward, Locality..." />
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Jar Count</label>
              <input type="number" value="1" min="1" max="20" />
            </div>
            <div class="form-group">
              <label>Source Station</label>
              <select>
                <option>Eco Pure Station</option>
                <option>AQua Hub South</option>
                <option>Bhaktapur Eco Water</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Notes (Optional)</label>
            <textarea placeholder="Special instructions..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-ghost" id="cancelBtn">Cancel</button>
          <button class="btn btn-primary">Dispatch Order</button>
        </div>
      </div>
    </div>

    <script>
      // ---- Live Clock ----
      function updateClock() {
        const now = new Date();
        document.getElementById("liveClock").textContent =
          now.toLocaleTimeString("en-US", { hour12: false });
      }
      setInterval(updateClock, 1000);
      updateClock();

      // ---- Today's Date ----
      document.getElementById("todayDate").textContent =
        new Date().toLocaleDateString("en-US", {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric",
        });

      // ---- Sidebar toggle ----
      const sidebar = document.getElementById("sidebar");
      const mainWrap = document.getElementById("mainWrap");
      document.getElementById("sidebarToggle").addEventListener("click", () => {
        sidebar.classList.toggle("collapsed");
        mainWrap.classList.toggle("expanded");
      });

      // ---- Mobile menu ----
      document.getElementById("mobileMenuBtn").addEventListener("click", () => {
        sidebar.classList.toggle("mobile-open");
      });

      // ---- Nav active state ----
      document.querySelectorAll(".nav-link").forEach((link) => {
        link.addEventListener("click", (e) => {
          e.preventDefault();
          document
            .querySelectorAll(".nav-link")
            .forEach((l) => l.classList.remove("active"));
          link.classList.add("active");
          document.querySelector(".breadcrumb-current").textContent =
            link.querySelector(".nav-text").textContent;
          if (window.innerWidth < 900) sidebar.classList.remove("mobile-open");
        });
      });

      // ---- Tab switch ----
      function switchTab(btn) {
        document
          .querySelectorAll(".tab")
          .forEach((t) => t.classList.remove("active"));
        btn.classList.add("active");
      }

      // ---- Modal ----
      const modal = document.getElementById("modalOverlay");
      document
        .getElementById("newDeliveryBtn")
        .addEventListener("click", () => {
          modal.classList.add("open");
        });
      document.getElementById("modalClose").addEventListener("click", () => {
        modal.classList.remove("open");
      });
      document.getElementById("cancelBtn").addEventListener("click", () => {
        modal.classList.remove("open");
      });
      modal.addEventListener("click", (e) => {
        if (e.target === modal) modal.classList.remove("open");
      });

      // ---- Counter animation ----
      function animateCounters() {
        document.querySelectorAll(".counter").forEach((el) => {
          const target = parseInt(el.dataset.target);
          const duration = 1200;
          const step = target / (duration / 16);
          let current = 0;
          const timer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = Math.floor(current).toLocaleString();
            if (current >= target) clearInterval(timer);
          }, 16);
        });
      }

      // ---- Chart bar hover ----
      document.querySelectorAll(".chart-bar").forEach((bar) => {
        bar.addEventListener("mouseenter", () => {
          bar.querySelector(".bar-tooltip").style.opacity = "1";
          bar.querySelector(".bar-tooltip").style.transform =
            "translateX(-50%) translateY(-4px)";
        });
        bar.addEventListener("mouseleave", () => {
          bar.querySelector(".bar-tooltip").style.opacity = "0";
          bar.querySelector(".bar-tooltip").style.transform =
            "translateX(-50%) translateY(0)";
        });
      });

      // ---- Scroll reveal ----
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((e) => {
            if (e.isIntersecting) {
              e.target.classList.add("visible");
              animateCounters();
            }
          });
        },
        { threshold: 0.05 },
      );

      document.querySelectorAll(".kpi-card, .panel").forEach((el) => {
        el.classList.add("reveal");
        observer.observe(el);
      });

      // ---- Live log simulation ----
      const events = [
        { dot: "green", title: "JAR-4827 Delivered", sub: "Dinesh T. · Thimi" },
        {
          dot: "blue",
          title: "New Order Received",
          sub: "Customer #2842 · Bhaktapur",
        },
        {
          dot: "orange",
          title: "Driver Dispatched",
          sub: "DRV-038 · Baneshwor route",
        },
      ];
      let evIdx = 0;
      setInterval(() => {
        const log = document.getElementById("activityLog");
        const ev = events[evIdx % events.length];
        const now = new Date().toLocaleTimeString("en-US", {
          hour: "2-digit",
          minute: "2-digit",
        });
        const item = document.createElement("div");
        item.className = "log-item new-log";
        item.innerHTML = `
        <div class="log-dot ${ev.dot}"></div>
        <div class="log-body">
          <p><strong>${ev.title}</strong></p>
          <span>${ev.sub} · ${now}</span>
        </div>`;
        log.insertBefore(item, log.firstChild);
        if (log.children.length > 8) log.removeChild(log.lastChild);
        setTimeout(() => item.classList.remove("new-log"), 500);
        evIdx++;
      }, 7000);

      // ---- Init ----
      animateCounters();
    </script>
  </body>
</html>
