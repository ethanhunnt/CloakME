<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Analyze Social Media Exposure</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <div class="container">
        <h1>Analyze Social Media Exposure</h1>
        <div>
            <label for="username">Instagram Username:</label>
            <input type="text" id="username" name="username">
            <button id="analyzeBtn">Analyze</button>
        </div>
        <div id="results">
            <h2>Exposure Score: <span id="score"></span></h2>
            <div id="indicatorsSection" style="display:none;">
                <h3>Risk Indicators:</h3>
                <ul id="indicatorsList"></ul>
            </div>
            <div id="postsSection">
                <h3>Instagram Posts:</h3>
                <div id="postsContainer"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#analyzeBtn').on('click', function () {
                const username = $('#username').val().trim();
                if (!username) {
                    alert("Please enter an Instagram username.");
                    return;
                }

                $.ajax({
                    url: '../php/social_analyzer_backend.php',
                    method: 'GET',
                    data: { username },
                    success: function (response) {
                        if (response.success) {
                            $('#score').text(response.score);

                            if (response.indicators) {
                                $('#indicatorsList').empty();
                                for (let key in response.indicators) {
                                    $('#indicatorsList').append(`<li>${key}: ${response.indicators[key]}</li>`);
                                }
                                $('#indicatorsSection').show();
                            }

                            if (response.posts && response.posts.length > 0) {
                                $('#postsContainer').empty();
                                response.posts.forEach(post => {
                                    $('#postsContainer').append(
                                        `<a href="${post.link}" target="_blank"><img src="${post.thumbnail}" alt="post" class="thumbnail"/></a>`
                                    );
                                });
                            } else {
                                $('#postsContainer').html('<p>No posts found or API failed.</p>');
                            }
                        } else {
                            $('#score').text('Error');
                            $('#postsContainer').html('<p>Error retrieving data.</p>');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
