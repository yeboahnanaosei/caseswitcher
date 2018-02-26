const $ = id => document.getElementById(id);

$('ignore').addEventListener('click', function() {
  const inp = this.querySelector('input');
  inp.focus();
}, false);

//check on writing
$('ignore-field').addEventListener('input', function(e) {
  const { value } = this,
  l = value.length;
  if(l > 0) {
    this.style.width = (7 * l) + 'px';
  }
  else {
    this.style.width = '7px';
  }
}, false);

//check enter
$('ignore-field').addEventListener('keyup', e => {
  if(e.keyCode === 13){
    const { target } = e;
    const div = document.createElement('div');
    const txt = document.createTextNode(target.value);

    div.className = 'ignore-item';
    div['data-value'] = target.value;

    div.appendChild(txt);

    target.parentNode.insertBefore(div, target);
    target.value = '';
    target.style.width = '7px';
  }
}, false)
