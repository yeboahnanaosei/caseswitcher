var output   = document.querySelector('#feedback');

// Click to dismiss error message
output.addEventListener("click", (e) => {
    output.style.display = "none";
});

// Make an ajax call when the form is submitted
document.forms['rename-form'].addEventListener('submit', e => {
    e.preventDefault();    
    
    output.style.display = "block";
    var path     = document.forms['rename-form']['path'].value;
    var caseType = document.forms['rename-form']['case-type'].value;

    if (path == null || path == '') {
        return;
    }
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        request = new ActiveXObject('Microsoft.XMLHTTP');
    }

    request.open('POST', 'file-renamer.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    request.onload = () => {
        if (request.status == 200 && request.readyState == 4) {
            output.innerHTML = request.responseText;
        } else {
            output.innerHTML = 'Hold on... renaming your file(s)';
        }
    }
    
    request.send(encodeURI("path=" + path + "&case-type=" + caseType));
});
