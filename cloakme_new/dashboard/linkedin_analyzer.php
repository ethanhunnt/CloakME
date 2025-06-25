<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LinkedIn Exposure Analyzer</title>
    <link rel="stylesheet" href="../css/style.css">
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
	  <a href="twitter_impersonation.html">Twttr Soc Detect</a>
      <a href="securevault.php">SecureVault</a>
      <a href="../php/logout.php">Logout</a>
    </nav>
  </header>
  
	<div class="container">
    <h1>LinkedIn Exposure Score</h1>
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
	</div>
</body>
</html>
