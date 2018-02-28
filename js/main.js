window.addEventListener('load', function(){
  let
    $ = id => document.getElementById(id),
    subBtn = $('submit-btn'),
    output = $('feedback'),
    form   = $('rename-form');

  //change the btn color based on the str length
  function getStrLn(el) {
    const _el = el.nodeType === 1 ? el : el.target;
    subBtn.disabled = _el.value.trim().length !== 0 ? false : true;
  }

  getStrLn($('path'));// on document load
  $('path').addEventListener('input', getStrLn.bind(this), false); //on input key up

  // Click to dismiss error message
  output.addEventListener('click', e => {
      output.style.display = 'none';
  });

  // Make an ajax call when the form is submitted
  form.addEventListener('submit', e => {
      e.preventDefault();
      let path      = $('path').value.trim();
      let caseType  = form['case-type'].value;
      let recursion = form['recursion'];

      // See if the user checked the recursion or subfolder option on the form
      // and set the appropriate value to be sent to the php class
      if (recursion.checked) {
          recursion.value = 'true';
      } else {
          recursion.value = 'false'
      }

      output.style.display = 'block';

      if (!!!path) return;

      const request =
        XMLHttpRequest ?
        new XMLHttpRequest() :
        new ActiveXObject('Microsoft.XMLHTTP');

      request.open('POST', 'file-renamer.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      request.onload = () => {
        output.innerHTML =
          request.status == 200 && request.readyState == 4 ?
          request.responseText :
          'Hold on... renaming your file(s)';
      }

      request.send(encodeURI("path=" + path + "&case-type=" + caseType + "&recursion=" + recursion.value));
  });

}, false)
