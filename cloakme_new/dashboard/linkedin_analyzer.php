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
  <title>LinkedIn Exposure Analyzer</title>
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
    <h1>LinkedIn Exposure Score</h1>
    <form id="analyzer-form">
      <label for="linkedinUrl">LinkedIn Profile URL:</label>
      <input type="text" id="linkedinUrl" name="linkedinUrl" placeholder="Enter full LinkedIn URL" required>
      <button type="submit">Analyze</button>
    </form>
    <div id="result" class="result"></div>
  </div>

  <script>
    document.getElementById("analyzer-form").addEventListener("submit", async function (event) {
      event.preventDefault();
      const url = document.getElementById("linkedinUrl").value;
      const resultDiv = document.getElementById("result");
      resultDiv.innerHTML = "⏳ Analyzing...";

      try {
        const response = await fetch(`../php/linkedin_analyzer.php?url=${encodeURIComponent(url)}`);
        const data = await response.json();

        if (data.error) {
          resultDiv.innerHTML = `<p style="color:red;">❌ ${data.error}</p>`;
          return;
        }

        let html = `<h3>${data.name || 'Unknown Name'}</h3>`;
        if (data.image) {
          html += `<img src="${data.image}" alt="Profile Image" width="100" style="border-radius:50%;margin-top:10px;">`;
        }

        html += `
          <p><strong>Headline:</strong> ${data.headline || 'N/A'}</p>
          <p><strong>Location:</strong> ${data.location || 'N/A'}</p>
          <p><strong>About:</strong> ${data.about || 'N/A'}</p>
          <hr>
          <h3 style="margin-top:10px;">Exposure Score: ${data.score}/100</h3>
          <p><strong>Risk Level:</strong> ${data.level}</p>
          <p><em>${data.message}</em></p>
        `;

        resultDiv.innerHTML = html;
        resultDiv.className = "result " + data.level;
      } catch (error) {
        resultDiv.innerHTML = `<p style="color:red;">❌ Failed to analyze. Please try again later.</p>`;
      }
    });
  </script>
</body>
</html>
