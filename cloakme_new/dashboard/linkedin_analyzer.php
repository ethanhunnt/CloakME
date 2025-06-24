<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LinkedIn Exposure Analyzer</title>
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        input, button {
            padding: 10px;
            margin: 10px 0;
            width: 100%%;
            background-color: #1e1e1e;
            color: #ffffff;
            border: 1px solid #444;
        }
        .result {
            margin-top: 20px;
            padding: 20px;
            border-radius: 5px;
        }
        .low { background-color: #2e7d32; }
        .medium { background-color: #fbc02d; }
        .high { background-color: #c62828; }
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

    <h1>LinkedIn Exposure Analyzer</h1>
    <form id="analyzer-form">
        <label for="linkedinUrl">LinkedIn Profile URL:</label>
        <input type="text" id="linkedinUrl" name="linkedinUrl" placeholder="Enter full LinkedIn URL" required>
        <button type="submit">Analyze</button>
    </form>
    <div id="result" class="result"></div>

    <script>
        document.getElementById("analyzer-form").addEventListener("submit", async function(event) {
            event.preventDefault();
            const url = document.getElementById("linkedinUrl").value;

            const response = await fetch("../php/linkedin_analyzer.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "linkedinUrl=" + encodeURIComponent(url)
            });

            const data = await response.json();
            const resultDiv = document.getElementById("result");
            resultDiv.innerHTML = "<h3>Score: " + data.score + "</h3><p>" + data.message + "</p>";
            resultDiv.className = "result " + data.level;
        });
    </script>
</body>
</html>
