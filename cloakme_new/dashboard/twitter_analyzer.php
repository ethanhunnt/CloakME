
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Twitter Exposure Analyzer</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
        }
        input, button {
            padding: 10px;
            font-size: 16px;
            margin: 10px;
            border-radius: 5px;
        }
        input {
            background-color: #1e1e1e;
            color: white;
            border: 1px solid #333;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
        }
        #resultBox {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            white-space: pre-wrap;
        }
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
      <a href="securevault.php">SecureVault</a>
      <a href="../php/logout.php">Logout</a>
    </nav>
  </header>

    <h1>Twitter Exposure Analyzer</h1>
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
</body>
</html>
