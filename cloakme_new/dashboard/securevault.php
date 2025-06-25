<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CloakMe | Secure Vault</title>
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
      <a href="securevault.php">SecureVault</a>
      <a href="../php/logout.php">Logout</a>
    </nav>
  </header>

  <div class="container">
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
  </div>
</body>
</html>
