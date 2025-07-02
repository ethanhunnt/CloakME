<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dark Web Scanner - CloakMe</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      background-color: #111;
      color: #0ff;
      font-family: Arial, sans-serif;
    }

    .container {
      padding: 20px;
    }

    input[type="text"] {
      width: 80%;
      padding: 10px;
      font-size: 16px;
      background-color: #222;
      color: #fff;
      border: none;
      border-radius: 4px;
    }

    button {
      padding: 10px 20px;
      background-color: #00d4ff;
      color: #000;
      font-weight: bold;
      font-size: 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-left: 10px;
    }

    h2 {
      margin-top: 20px;
      color: #0ff;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #444;
      color: #fff;
    }

    th {
      background-color: #222;
      color: #0ff;
      text-align: left;
    }

    tr:nth-child(even) {
      background-color: #1a1a1a;
    }

    .no-results {
      color: red;
      font-weight: bold;
      margin-top: 10px;
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
      <a href="linkedin_analyzer.php">LinkedIn Social Analyzer</a>
      <a href="instagram_impersonation_detect.php">Insta Soc Detect</a>
      <a href="twitter_impersonation.html">Twttr Soc Detect</a>
      <a href="securevault.php">SecureVault</a>
      <a href="../php/logout.php">Logout</a>
    </nav>
  </header>
  <div class="container">
    <h1>Dark Web Scanner - CloakMe</h1>
    <input type="text" id="queryInput" placeholder="Enter name, email, or keyword">
    <button onclick="scanDarkWeb()">Search</button>

    <div id="resultsContainer"></div>
  </div>

 <script>
  function scanDarkWeb() {
    const query = document.getElementById("queryInput").value.trim();
    if (!query) {
      alert("Please enter a query");
      return;
    }

    const resultsContainer = document.getElementById("resultsContainer");
    resultsContainer.innerHTML = "<p>Searching...</p>";

    fetch(`/php/dark_hub.php?query=${encodeURIComponent(query)}&source=all`)
      .then(response => response.json())
      .then(data => {
        resultsContainer.innerHTML = `<h2>Results for: ${data.query}</h2>`;

        const results = data.results;
        let found = false;

        const table = document.createElement("table");
        const headerRow = document.createElement("tr");
        headerRow.innerHTML = "<th>Source</th><th>Result Snippet</th><th>Risk Level</th>";
        table.appendChild(headerRow);

        const sources = Object.keys(results);
        sources.forEach(source => {
          const sourceData = results[source];
          const organicResults = sourceData && sourceData.organic_results;

          if (organicResults && Array.isArray(organicResults) && organicResults.length > 0) {
            found = true;

            organicResults.forEach(item => {
              const row = document.createElement("tr");

              // Source Cell
              const sourceCell = document.createElement("td");
              sourceCell.textContent = source.charAt(0).toUpperCase() + source.slice(1);
              row.appendChild(sourceCell);

              // Snippet Cell
              const snippetCell = document.createElement("td");
              snippetCell.innerHTML = `<a href="${item.link}" target="_blank">${item.title}</a><br>${item.snippet}`;
              row.appendChild(snippetCell);

              // Risk Level Cell
              const riskCell = document.createElement("td");
              const text = `${item.title} ${item.snippet}`.toLowerCase();

              let risk = "Low";
              let color = "limegreen";

              if (/password|credential|login|dump|database|compromised|leak/.test(text)) {
                risk = "High";
                color = "red";
              } else if (/email|username|data|breach/.test(text)) {
                risk = "Medium";
                color = "orange";
              }

              riskCell.textContent = risk;
              riskCell.style.color = color;
              row.appendChild(riskCell);

              table.appendChild(row);
            });
          }
        });

        if (found) {
          resultsContainer.appendChild(table);
        } else {
          resultsContainer.innerHTML += `<p class="no-results">No results found on any source.</p>`;
        }
      })
      .catch(error => {
        console.error("Error:", error);
        resultsContainer.innerHTML = `<p class="no-results">An error occurred. Please try again.</p>`;
      });
  }
</script>

</body>
</html>
