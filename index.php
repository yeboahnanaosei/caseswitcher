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
        <p>
            <b>CaseSwitcher</b> is a simple script that changes 
            filenames to either lowercase or UPPERCASE<br>
            Just enter the path to the file or directory 
            you want to change and hit the rename button.
            <b><i>It's that simple...</i></b>
        </p>
    </div>
    
    <!-- Form starts -->
    <form method="POST" action="file-renamer.php" name="rename-form">
        <h2 class="window-title">CaseSwitcher <span><i><small>It's that simple...</small></i></span></h2>
        
        <!-- Path -->
        <input type="text" name="path" placeholder="Enter path to file or directory" id="path" class="path" tabindex="1">
        <br>
        <br>
        
        <!-- Select case type -->
        <small class="info"><i>(Choose your case)</i></small>
        <br>
        <input type="radio" name="case-type" value="lower" id="lower" checked> <label for="lower">lowercase</label> 
        &nbsp;
        <input type="radio" name="case-type" value="upper" id="upper"> <label for="upper">UPPERCASE</label>
        <br>
        <br>
        
        <!-- Submit button -->
        <input type="submit" name="rename" value="Rename" id="submit-btn" class="submit-btn" tabindex="2">
    </form>
    <br>

    <!-- Feedback -->
    <div><p id='feedback' title="Click to dismiss"></p></div>
    
    <!-- JS and AJAX -->
    <script src="js/main.js"></script>
</body>
</html>
