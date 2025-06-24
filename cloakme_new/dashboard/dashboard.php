<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CloakMe Dashboard</title>
  <style>
    body {
      background-color: #121212;
      color: #f0f0f0;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #1f1f1f;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #333;
    }
    .logo {
      font-size: 20px;
      font-weight: bold;
      color: #00ffff;
    }
    nav a {
      margin-left: 20px;
      color: #9fa8da;
      text-decoration: none;
      font-size: 15px;
      transition: color 0.3s;
    }
    nav a:hover {
      color: #ffffff;
    }
    main {
      padding: 40px;
      max-width: 1000px;
      margin: 0 auto;
    }
    h1 {
      color: #ffffff;
      font-size: 28px;
      margin-bottom: 30px;
    }
    .overview-chart {
      background-color: #1e1e1e;
      padding: 20px;
      border-radius: 10px;
      min-height: 300px;
      color: #ccc;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">🛡️ CloakMe</div>
    <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="scan.php">Dark Web Scanner</a>
      <a href="social_analyzer.php">Social Analyzer</a>
      <a href="securevault.php">SecureVault</a>
      <a href="../php/logout.php">Logout</a>
    </nav>
  </header>

  <main>
    <h1>Your CloakMe Security Overview</h1>
    <div class="overview-chart">
      <!-- Placeholder: insert chart.js canvas or metrics -->
      <p>📊 Charts and metrics will appear here.</p>
    </div>
  
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<canvas id="riskChart" width="800" height="300"></canvas>
<script>
  const ctx = document.getElementById('riskChart').getContext('2d');
  const riskChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Breaches', 'Risk Exposure', 'Safe Score', 'Files Stored'],
      datasets: [{
        label: 'Security Metrics',
        data: [1, 2, 3, 4],
        backgroundColor: ['#ef5350', '#ffca28', '#29b6f6', '#66bb6a']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: {
          display: true,
          text: 'CloakMe Security Overview',
          color: '#fff',
          font: {
            size: 18
          }
        }
      },
      scales: {
        x: { ticks: { color: '#ccc' }, grid: { color: '#333' } },
        y: { ticks: { color: '#ccc' }, grid: { color: '#333' } }
      }
    }
  });
</script>

</main>
</body>
</html>
