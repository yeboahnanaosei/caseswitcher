<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    <style media="screen">
        .h1 {
          color: red;
        }
        [data-nana="mat"] {
          color: blue;
        }
    </style>
  </head>
  <body>

    <h1 class="h1" data-extends-ui="mat">Hello, world!</h1>
    <form method="POST" action="zip-parser.php" id="rename-form" enctype="multipart/form-data">
      <h2 class="window-title">
        CaseSwitcher
        <span><i><small>It's that simple...</small></i></span>
      </h2>

      <div class="form-group">
        <p class="label">Upload a zip file</p>
        <!-- <input type="text" name="path" placeholder="Enter path to file or directory" id="path" class="path" autofocus> -->
        <input type="file" name="zip" class="path" accept="application/x-zip-compressed" required>
      </div>
      <div class="form-group">
        <p>Ignore</p>
        <div class="path" id="ignore" title="type the text and press ';'">
          <input type="text" name="ignore" class="ignore" tabindex="1" id="ignore-field">
        </div>
      </div>

      <!-- With subfolders and files -->
      <div class="form-group">
        <input type="checkbox" name="sub-folders" id="sub" value="true">
        <label for="sub">With sub folders and files</label>
      </div>

      <!-- Choose case -->
      <div class="form-group">
        <label class="info"><i><small>(Choose your case)</small></i></label>
        <input type="radio" name="case-type" value="lower" id="lower" checked> <label for="lower">lowercase</label>
        &nbsp;
        <input type="radio" name="case-type" value="upper" id="upper"> <label for="upper">UPPERCASE</label>
      </div>

      <!-- Submit button -->
      <input type="submit" name="rename" value="Rename" id="submit-btn" class="submit-btn">
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
  </body>
</html>
