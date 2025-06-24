
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Instagram Impersonation Detector</title>
  <style>
    body { background-color: #121212; color: #fff; font-family: Arial, sans-serif; padding: 20px; }
    h1 { color: #90caf9; }
    input, button { margin: 10px 5px; padding: 10px; font-size: 16px; }
    table { width: 100%; margin-top: 20px; border-collapse: collapse; }
    th, td { padding: 8px; text-align: left; border-bottom: 1px solid #444; }
    img { border-radius: 50%; width: 40px; height: 40px; }
    .risk-Low { color: green; }
    .risk-Medium { color: orange; }
    .risk-High { color: red; }
  </style>
</head>
<body>
  <header>
    <div class="logo">🛡️ CloakMe</div>
    <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="scan.php">Dark Web Scanner</a>
      <a href="social_analyzer.php">Insta Social Analyzer</a>
	  <a href="twitter_analyzer.php">Twitter Social Analyzer</a>
	  <a href="linkedin_analyzer.php">LinkedIn Social Analyzer</a>
	  <a href="instagram_impersonation_detect.php">Insta Soc Detect</a>
      <a href="securevault.php">SecureVault</a>
      <a href="../php/logout.php">Logout</a>
    </nav>
  </header>

  <h1>Instagram Impersonation Detector</h1>
  <label>Actual Username:</label>
  <input type="text" id="actualUsername" placeholder="e.g. mipalkarofficial" />
  <label>Search Query (Name):</label>
  <input type="text" id="searchQuery" placeholder="e.g. mithila palkar" />
  <button onclick="analyze()">Detect Impersonators</button>

  <div id="results"></div>

  <script>
    function analyze() {
      const actual = document.getElementById('actualUsername').value;
      const query = document.getElementById('searchQuery').value;
      fetch('../php/instagram_impersonation_detect.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'actual_username=' + encodeURIComponent(actual) + '&search_query=' + encodeURIComponent(query)
      })
      .then(response => response.json())
      .then(data => {
        let html = '<table><tr><th>Profile Pic</th><th>Username</th><th>Full Name</th><th>Followers</th><th>Verified</th><th>Risk</th></tr>';
        data.forEach(u => {
          html += `<tr>
            <td><img src="${u.profile_pic_url}" alt="pic" /></td>
            <td>${u.username}</td>
            <td>${u.full_name}</td>
            <td>${u.followers}</td>
            <td>${u.verified}</td>
            <td class="risk-${u.risk_level}">${u.risk_level}</td>
          </tr>`;
        });
        html += '</table>';
        document.getElementById('results').innerHTML = html;
      });
    }
  </script>
</body>
</html>
