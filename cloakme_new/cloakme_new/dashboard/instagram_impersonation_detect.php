<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Instagram Impersonation Detector</title>
  <link rel="stylesheet" href="../css/style.css" />
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
    <h2>Instagram Impersonation Detector</h2>

    <div class="search-container">
      <input type="text" id="actualUsername" placeholder="Actual Username" />
      <input type="text" id="searchQuery" placeholder="Search Query (Name)" />
      <button onclick="detectImpersonators()">Detect Impersonators</button>
    </div>

    <div id="spinner" class="spinner hidden"></div>
    <div id="results"></div>
  </div>

  <script>
    function detectImpersonators() {
      const actual = document.getElementById('actualUsername').value.trim();
      const query = document.getElementById('searchQuery').value.trim();

      if (!actual || !query) {
        alert("Please enter both actual username and search query.");
        return;
      }

      document.getElementById('results').innerHTML = '';
      document.getElementById('spinner').classList.remove('hidden');

      fetch('../php/instagram_impersonation_detect.php?actual_username=' + encodeURIComponent(actual) + '&search_query=' + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
          if (!Array.isArray(data)) throw new Error("Invalid response");

          let table = `<table>
            <thead>
              <tr>
                <th>Profile Pic</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Followers</th>
                <th>Verified</th>
                <th>Risk</th>
                <th>Note</th>
              </tr>
            </thead>
            <tbody>`;

          data.forEach(entry => {
            const riskClass = entry.risk_level ? 'risk-' + entry.risk_level.toLowerCase() : '';
            const verifiedClass = entry.verified === "Yes" ? 'verified-yes' : 'verified-no';
            const note = entry.note === "Original profile" ? `<span class="original-tag">${entry.note}</span>` : (entry.note || '');

            table += `
              <tr class="${riskClass}">
                <td><img src="${entry.profile_pic_base64}" alt="Pic" width="40" height="40"/></td>
                <td>${entry.username}</td>
                <td>${entry.full_name}</td>
                <td>${entry.followers || '0'}</td>
                <td class="${verifiedClass}">${entry.verified}</td>
                <td class="risk-cell ${riskClass}">${entry.risk_level}</td>
                <td>${note}</td>
              </tr>`;
          });

          table += `</tbody></table>`;
          document.getElementById('results').innerHTML = table;
        })
        .catch(err => {
          console.error("Error:", err);
          document.getElementById('results').innerHTML = '<p style="color: red;">Failed to load data.</p>';
        })
        .finally(() => {
          document.getElementById('spinner').classList.add('hidden');
        });
    }
  </script>
</body>
</html>
