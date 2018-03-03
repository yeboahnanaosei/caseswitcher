jQuery(document).ready(function() {
    let $subBtn = $('#submit-btn'),
        $output = $('#feedback'),
        $form = $('#rename-form'),
        $path = $('#path');

    //change the btn color based on the str length
    function getStrLn(el) {
        console.log(el);
        
        const _el = el[0].nodeType === 1 ? el[0] : el[0].target
        $subBtn.disabled = _el.value.trim().length !== 0 ? false : true
    }

    getStrLn($path) // on document load
    $path.keyup(getStrLn.bind(this)) //on input key up

    // Click to dismiss error message
    $output.click( e => {
        $output.style.display = 'none'
    })

    // Make an ajax call when the form is submitted
    $form.submit( e => {
        e.preventDefault()

        const path = $path.val().trim()
        const caseType = $form['case-type'].val()
        const subfolders = $('#sub').checked ? 'true' : 'false'
        const ignored = [...$('#ignore').children]
            .map(div => {
                if ($(div).attr('data-value')) {
                    return $(div).attr('data-value')
                }
            })
            .filter(data => data)

        output.style.display = 'block'

        if (!!!path) return

        const request = XMLHttpRequest
            ? new XMLHttpRequest()
            : new ActiveXObject('Microsoft.XMLHTTP')

        request.open('POST', 'file-renamer.php', true)
        request.setRequestHeader(
            'Content-Type',
            'application/x-www-form-urlencoded'
        )

        request.onload = () => {
            output.innerHTML =
                request.status == 200 && request.readyState == 4
                    ? request.responseText
                    : 'Hold on... renaming your file(s)'
        }

        request.send(
            encodeURI(
                `path=${path}&case-type=${caseType}&sub-folders=${subfolders}&ignored=${ignored}`
            )
        )
    })
})