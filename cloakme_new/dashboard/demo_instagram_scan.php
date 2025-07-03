<!-- File: dashboard/demo_instagram_scan.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-1012263395"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-1012263395');
</script>
  <meta charset="UTF-8">
  <title>CloakMe Demo – Instagram Analyzer</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .risk-low { background-color: #d4edda; }
    .risk-medium { background-color: #fff3cd; }
    .risk-high { background-color: #f8d7da; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
  </style>
</head>
<body>
  <header>
    <div class="logo">🛡️ CloakMe</div>
    <nav>
      <a href="../index.html">Home</a>
    </nav>
  </header>

  <main style="padding: 20px;">
    <h2>Demo: Instagram Exposure Analysis</h2>
    <p>Analyzing sample account <strong>@cristiano</strong>...</p>

    <h3>👤 Account Info</h3>
    <ul>
      <li><strong>Username:</strong> cristiano</li>
      <li><strong>Followers:</strong> 630M</li>
      <li><strong>Bio:</strong> Join my journey 🏆 | Athlete | Humanitarian</li>
      <li><strong>Risk Level:</strong> <span style="color: red;">High</span></li>
    </ul>

    <h3>🔍 Detected Impersonators</h3>
    <table>
      <tr>
        <th>Username</th>
        <th>Followers</th>
        <th>Verified</th>
        <th>Risk</th>
      </tr>
      <tr class="risk-high">
        <td>cristiano.real_</td>
        <td>12,000</td>
        <td>No</td>
        <td>High</td>
      </tr>
      <tr class="risk-medium">
        <td>cristianoo.official</td>
        <td>2,300</td>
        <td>No</td>
        <td>Medium</td>
      </tr>
      <tr class="risk-low">
        <td>cristiano_funpage</td>
        <td>600</td>
        <td>No</td>
        <td>Low</td>
      </tr>
    </table>

    <div style="margin-top: 30px;">
      <p><strong>Want a report on your own account?</strong></p>
      <a href="social_analyzer_step1.php" class="cta-button">🧪 Try Your Own Scan</a>
    </div>
  </main>
</body>
</html>
