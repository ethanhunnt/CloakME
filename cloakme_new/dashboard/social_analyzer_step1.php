<!DOCTYPE html>
<html>
<head>
    <title>Instagram Exposure Analyzer - v1</title>
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

  <main class="main-content">
    <h2>Instagram Analyzer (v1)</h2>
    <div class="input-group">
        <input type="text" id="username" placeholder="Enter Instagram username">
        <button onclick="analyze()">Analyze</button>
    </div>

    <div class="result" id="result"></div>
  </main>

  <script>
    function analyze() {
        let username = $('#username').val().trim();
        if (!username) {
            alert('Please enter a username.');
            return;
        }

        $('#result').html('<p>Loading...</p>');

        $.get('../php/social_analyzer_backend_step1.php', { username: username }, function(data) {
            if (!data.success) {
                $('#result').html('<p class="error">Error: ' + data.error + '</p>');
                return;
            }

            let html = '<div class="profile-summary">';
            html += '<img class="profile-pic" src="' + data.profile_pic_base64 + '" alt="Profile Picture">';
            html += '<div class="profile-details">';
            html += '<p><strong>Username:</strong> ' + data.username + '</p>';
            html += '<p><strong>Full Name:</strong> ' + data.full_name + '</p>';
            html += '<p><strong>Followers:</strong> ' + data.follower_count + '</p>';
            html += '<p><strong>Posts:</strong> ' + data.media_count + '</p>';
            html += '<p><strong>Score:</strong> ' + data.score + '</p>';

            html += '<p><strong>Posts with Hashtags:</strong> ' + data.hashtag_post_count + '</p>';
            if (data.hashtags && data.hashtags.length > 0) {
                html += '<p><strong>Hashtags:</strong> ' + data.hashtags.map(tag => '#' + tag).join(', ') + '</p>';
            }

            html += '<p><strong>Posts with Geotags:</strong> ' + data.geo_tagged_post_count + '</p>';
            if (data.locations && data.locations.length > 0) {
                html += '<p><strong>Geotag Locations:</strong> ' + data.locations.join(', ') + '</p>';
            }

            let recommendation = "";
            if (data.score <= 30) {
                recommendation = "✅ Your profile is secure. Keep good practices going!";
            } else if (data.score <= 70) {
                recommendation = "⚠️ Medium exposure. Consider reviewing past posts and ensure that you monitor impersonation.";
            } else {
                recommendation = "🚨 High exposure! Remove sensitive posts, and monitor impersonation.";
            }

            html += '<div class="recommendation-box">' + recommendation + '</div>';
            html += '</div></div>';

            html += '<h4>Sample Posts</h4><div class="post-gallery">';
            data.posts.forEach(function(post) {
                html += '<a href="' + post.post_url + '" target="_blank">';
                html += '<img class="post-img" src="' + post.image_base64 + '" alt="Post Image" onerror="this.style.display=\'none\'">';
                html += '</a>';
            });
            html += '</div>';

            $('#result').html(html);
        }, 'json');
    }
  </script>
</body>
</html>
