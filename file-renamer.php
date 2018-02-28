<?php
namespace caseswitcher;

include 'classes/CaseSwitcher.php';

// Create a new instance of CaseSwitcher
$path = new CaseSwitcher($_POST['path'], $_POST['case-type'], $_POST['recursion']);

if ($path->rename()) {
    echo "<p class='feedback success' title='click to close'>SUCCESS:<br>Your file was renamed successfully</p>";
} else {
    echo "<p class='feedback error' title='click to close'>FAILURE: {$path->getErrorMsg()}</p>";
}
