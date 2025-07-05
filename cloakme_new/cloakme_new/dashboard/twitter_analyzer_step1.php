
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Twitter Exposure Analyzer</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <h1>Twitter Exposure Score</h1>
    <input type="text" id="username" placeholder="Enter Twitter Username">
    <button onclick="analyze()">Analyze</button>

    <div id="scoreBox">Score: <span id="score">--</span></div>

    <div id="profile-info" style="margin-top: 20px;">
      <img id="profile-pic" style="border-radius: 50%; width: 80px;">
      <h3 id="profile-name"></h3>
      <p>@<span id="profile-username"></span></p>
      <p><strong>Bio:</strong> <span id="profile-desc"></span></p>
      <p><strong>Location:</strong> <span id="profile-loc"></span></p>
      <p><strong>Followers:</strong> <span id="profile-followers"></span></p>
    </div>

    <pre id="rawResponse" style="background:#111; color:#0f0; margin-top:30px; padding:10px; border-radius:10px;"></pre>
  </div>

<script>
function analyze() {
  const username = document.getElementById('username').value;
  fetch('../php/twitter_analyzer_backend_step1.php?username=' + encodeURIComponent(username))
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        alert(data.error);
        return;
      }

      // Score
      const scoreSpan = document.getElementById('score');
      scoreSpan.textContent = data.score;
      if (data.score <= 30) scoreSpan.style.color = "green";
      else if (data.score <= 70) scoreSpan.style.color = "orange";
      else scoreSpan.style.color = "red";
	  
	// Exposure Recommendation
	const existingNote = document.getElementById('exposure-note');
	if (existingNote) existingNote.remove();

	const note = document.createElement('div');
	note.id = 'exposure-note';
	note.style.marginTop = '15px';
	note.style.padding = '10px';
	note.style.borderRadius = '8px';
	note.style.fontWeight = 'bold';

	if (data.score <= 30) {
	  note.style.backgroundColor = '#d4edda'; // light green
	  note.style.color = '#155724';
	  note.textContent = '✅ Low exposure. You appear secure. Keep practicing good social media hygiene.';
	} else if (data.score <= 70) {
	  note.style.backgroundColor = '#fff3cd'; // light yellow
	  note.style.color = '#856404';
	  note.textContent = '⚠️ Medium exposure. Review recent tweets and tighten your privacy settings.';
	} else {
	  note.style.backgroundColor = '#f8d7da'; // light red
	  note.style.color = '#721c24';
	  note.textContent = '🚨 High exposure. Consider deleting risky tweets and review your privacy settings.';
	}

		document.getElementById('scoreBox').after(note);


      // Profile info
      document.getElementById('profile-name').textContent = data.account.name;
      document.getElementById('profile-username').textContent = data.account.username;
      document.getElementById('profile-desc').textContent = data.account.description;
      document.getElementById('profile-loc').textContent = data.account.location;
      document.getElementById('profile-followers').textContent = data.account.followers;
      document.getElementById('profile-pic').src = data.account.profile_image;
	  
	  // Show Sample Tweets
		const oldTweetsDiv = document.getElementById('sample-tweets');
		if (oldTweetsDiv) oldTweetsDiv.remove();  // clean up previous block

		const tweetsDiv = document.createElement('div');
		tweetsDiv.id = "sample-tweets";
		tweetsDiv.innerHTML = "<h3>Sample Tweets</h3>";

		if (data.tweets && data.tweets.length > 0) {
		  data.tweets.slice(0, 3).forEach(tweet => {
			const tweetBlock = document.createElement('div');
			tweetBlock.style.marginBottom = "12px";
			tweetBlock.innerHTML = `
			  <p style="margin-bottom: 4px;">"${tweet.text}"</p>
			  <a href="${tweet.url}" target="_blank">View Tweet</a><br>
			  <small><em>${new Date(tweet.created_at).toLocaleString()}</em></small>
			  <hr>
			`;
			tweetsDiv.appendChild(tweetBlock);
		  });
		} else {
		  tweetsDiv.innerHTML += "<p>No tweets found.</p>";
		}

		document.getElementById('profile-info').appendChild(tweetsDiv);

      // Raw JSON
      document.getElementById('rawResponse').textContent = JSON.stringify(data.raw, null, 2);
    })
    .catch(err => {
      alert("Request failed: " + err);
    });
}
</script>
</body>
</html>
