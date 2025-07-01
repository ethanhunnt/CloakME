
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Instagram Impersonation Detector</title>
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
  <h1>Instagram Impersonation Detector</h1>
  <label>Actual Username:</label>
  <input type="text" id="actualUsername" placeholder="e.g. mipalkarofficial" />
  <br/>
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
            <td><img src="${u.profile_pic_url.replace(/\\\//g, '/')}" alt="pic" width="50" height="50" /></td>
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
  </div>
</body>
</html>
