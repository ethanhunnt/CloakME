
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Twitter Exposure Analyzer</title>
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
    <h1>Twitter Exposure Score</h1>
    <input type="text" id="username" placeholder="Enter Twitter Username">
    <button onclick="analyze()">Analyze</button>
    <div id="resultBox">Results will appear here...</div>

    <script>
        async function analyze() {
            const username = document.getElementById('username').value;
            const resultBox = document.getElementById('resultBox');
            resultBox.innerText = 'Analyzing...';

            const response = await fetch('../php/twitter_analyzer_backend.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ username })
            });

            const data = await response.json();
            let color = 'white';

            if (data.score <= 33) color = 'green';
            else if (data.score <= 66) color = 'orange';
            else color = 'red';

            resultBox.innerHTML = `<b>Score:</b> <span style="color:${color}">${data.score}</span><br><br><b>Raw Response:</b><br><pre>${JSON.stringify(data.raw_response, null, 2)}</pre>`;
        }
    </script>
	</div>
</body>
</html>
