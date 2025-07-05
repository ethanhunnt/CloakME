<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dark Web Scanner - CloakMe</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .lds-dual-ring {
      display: inline-block;
      width: 64px;
      height: 64px;
    }

    .lds-dual-ring:after {
      content: " ";
      display: block;
      width: 46px;
      height: 46px;
      margin: 1px;
      border-radius: 50%;
      border: 5px solid #00ffff;
      border-color: #00ffff transparent #00ffff transparent;
      animation: lds-dual-ring 1.2s linear infinite;
    }

    @keyframes lds-dual-ring {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">🛡️ CloakMe</div>
    <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="scan.php">Dark Web Scanner</a>
      <a href="social_analyzer_step1.php">Insta Social Analyzer</a>
      <a href="twitter_analyzer_step1.php">Twitter Social Analyzer</a>
      <a href="linkedin_step1.php">LinkedIn Analyzer</a>
      <a href="securevault.php">Secure Vault</a>
    </nav>
  </header>

  <main>
    <h1>Dark Web Scanner - CloakMe</h1>
    <form id="scanForm">
      <input type="text" id="query" placeholder="Enter email, phone, or username" required>
      <button type="submit">Search</button>
    </form>

    <!-- Spinner -->
    <div id="spinner" style="display: none; text-align: center; margin-top: 20px;">
      <div class="lds-dual-ring"></div>
    </div>

    <!-- Results Table -->
    <div id="results" style="margin-top: 30px;"></div>
  </main>

  <script>
    document.getElementById('scanForm').addEventListener('submit', function (e) {
      e.preventDefault();

      const query = document.getElementById('query').value.trim();
      if (!query) return;

      const spinner = document.getElementById('spinner');
      const resultsDiv = document.getElementById('results');
      resultsDiv.innerHTML = '';
      spinner.style.display = 'block';

      fetch(`../php/dark_hub.php?query=${encodeURIComponent(query)}&source=all`)
        .then(res => res.json())
        .then(data => {
          spinner.style.display = 'none';

          if (!data.results || Object.keys(data.results).length === 0) {
            resultsDiv.innerHTML = '<p>No results found.</p>';
            return;
          }

          let html = '<table border="1" cellspacing="0" cellpadding="10"><tr><th>Title</th><th>Snippet</th><th>URL</th><th>Risk</th></tr>';
          for (let source in data.results) {
            data.results[source].forEach(entry => {
              const riskColor = entry.risk === 'High' ? 'red' : entry.risk === 'Medium' ? 'orange' : 'lightgreen';
              html += `<tr>
                <td>${entry.title}</td>
                <td>${entry.snippet}</td>
                <td><a href="${entry.url}" target="_blank">View</a></td>
                <td style="color:${riskColor}; font-weight:bold;">${entry.risk}</td>
              </tr>`;
            });
          }
          html += '</table>';
          resultsDiv.innerHTML = html;
        })
        .catch(err => {
          spinner.style.display = 'none';
          resultsDiv.innerHTML = '<p>Error retrieving results. Try again later.</p>';
          console.error(err);
        });
    });
  </script>
</body>
</html>
