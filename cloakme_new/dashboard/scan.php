<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dark Web Scanner</title>
  <link rel="stylesheet" href="../css/styles.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<header>
  <div class="logo">🛡️ CloakMe</div>
  <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="scan.php">Dark Web Scanner</a>
      <a href="social_analyzer.php">Insta Social Analyzer</a>
	  <a href="twitter_analyzer.php">Twitter Social Analyzer</a>
      <a href="securevault.php">SecureVault</a>
    <a href="../php/logout.php">Logout</a>
  </nav>
</header>

<section class="hero">
  <h1>Dark Web Breach Results</h1>
  <form method="POST" action="../php/real_scan.php" style="margin-bottom: 2rem;">
    <label for="email">Enter Email to Scan:</label>
    <input type="email" name="email" id="email" required>
    <button type="submit">Scan</button>
  </form>

  <div style="width: 100%; max-width: 400px; margin: auto;">
    <canvas id="breachChart"></canvas>
  </div>
</section>

<script>
  const breachCount = <?php echo $_SESSION['breach_count'] ?? 0; ?>;

  const ctx = document.getElementById('breachChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Leaked Accounts'],
      datasets: [{
        label: 'Leaked Accounts',
        data: [breachCount],
        backgroundColor: ['#ef476f']
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>
</body>
</html>
