<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/style.css" rel="stylesheet">
    <title>CaseSwitcher | It's that simple...</title>
</head>
<body>
  <div class="info-bar">
    <h1 id="title"><i>CaseSwitcher</i></h1>
    <p>
        <b>CaseSwitcher</b> is a simple script that changes
        filenames to either lowercase or UPPERCASE<br>
        Just enter the path to the file or directory
        you want to change and hit the rename button.
        <b><i>It's that simple...</i></b>
    </p>
  </div>

      <!-- Form starts -->
  <form method="POST" action="file-renamer.php" id="rename-form">
    <h2 class="window-title">
      CaseSwitcher
      <span><i><small>It's that simple...</small></i></span>
    </h2>

    <div class="form-group">
      <p>File or Folder</p>
      <input type="text" name="path" placeholder="Enter path to file or directory" id="path" class="path" tabindex="1" autofocus>
    </div>
    <div class="form-group">
      <p>Ignore</p>
      <div class="path" id="ignore">
        <input type="text" name="ignore" class="ignore" tabindex="1" id="ignore-field">
      </div>
    </div>
    <div class="form-group">
      <input type="checkbox" name="sub" id="sub">
      <label for="sub">With sub folders and files</label>
    </div>

    <div class="form-group">
      <label class="info"><i><small>(Choose your case)</small></i></label>
      <input type="radio" name="case-type" value="lower" id="lower" checked> <label for="lower">lowercase</label>
      &nbsp;
      <input type="radio" name="case-type" value="upper" id="upper"> <label for="upper">UPPERCASE</label>
    </div>

    <!-- Submit button -->
    <input type="submit" name="rename" value="Rename" id="submit-btn" class="submit-btn" tabindex="2">
  </form>

  <!-- Feedback -->
  <div id="feedback"></div>

    <!-- JS and AJAX -->
    <script src="js/miniSelectize.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
