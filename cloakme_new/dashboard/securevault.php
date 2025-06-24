<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CloakMe | Secure Vault</title>
  <style>
    body {
      background-color: #121212;
      color: #f0f0f0;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #1f1f1f;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #333;
    }
    .logo {
      font-size: 20px;
      font-weight: bold;
      color: #00ffff;
    }
    nav a {
      margin-left: 20px;
      color: #9fa8da;
      text-decoration: none;
      font-size: 15px;
      transition: color 0.3s;
    }
    nav a:hover {
      color: #ffffff;
    }
    main {
      padding: 30px;
      max-width: 800px;
      margin: 0 auto;
    }
    h2 {
      color: #ffffff;
    }
    form {
      margin-top: 20px;
      margin-bottom: 30px;
    }
    input[type="file"] {
      background: #222;
      color: #eee;
      padding: 10px;
      border: 1px solid #444;
      border-radius: 5px;
    }
    button {
      padding: 10px 20px;
      background-color: #00bcd4;
      border: none;
      border-radius: 5px;
      color: white;
      font-weight: bold;
      cursor: pointer;
      margin-left: 10px;
    }
    button:hover {
      background-color: #0097a7;
    }
    .file-item {
      margin: 10px 0;
      background-color: #1e1e1e;
      padding: 10px;
      border-radius: 5px;
    }
    .file-item a {
      color: #64b5f6;
      margin-left: 15px;
      text-decoration: none;
    }
    .file-item a:hover {
      text-decoration: underline;
    }
    .success {
      color: #66bb6a;
      margin-bottom: 20px;
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
	  <a href="instagram_impersonation_detect.php">Insta Soc Detect</a>
      <a href="securevault.php">SecureVault</a>
      <a href="../php/logout.php">Logout</a>
    </nav>
  </header>

  <main>
    <h2>Secure File Vault</h2>

    <?php if (isset($_GET['upload']) && $_GET['upload'] === 'success'): ?>
      <div class="success">✅ File uploaded securely and encrypted.</div>
    <?php endif; ?>

    <form action="../php/upload.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="vault_file" required />
      <button type="submit">Upload</button>
    </form>

    <h2>Stored Files</h2>
    <div id="file-list">
      <?php include('../php/list_files.php'); ?>
    </div>
  </main>
</body>
</html>
