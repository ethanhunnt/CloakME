<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CloakMe Dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
 <header>
    <div class="logo">🛡️ CloakMe</div>
    <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="scan.php">Dark Web Scanner</a>
      <a href="social_analyzer_step1.php">Insta Social Analyzer</a>
      <a href="twitter_analyzer_step1.php">Twitter Social Analyzer</a>
      <a href="linkedin_analyzer.php">LinkedIn Social Analyzer</a>
      <a href="instagram_impersonation_detect.php">Insta Soc Detect</a>
      <a href="twitter_impersonation.html">Twttr Soc Detect</a>
      <a href="securevault.php">SecureVault</a>
      <a href="../php/logout.php">Logout</a>
    </nav>
  </header>
  
  <div class="container">
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
</div>
</body>
</html>
