// const $ = id => document.getElementById(id);

// $('ignore').addEventListener('click', function(e) {
//   if(e.target === this){
//     const inp = this.querySelector('input');
//     inp.focus();
//   }
// }, false);

// //check on writing
// $('ignore-field').addEventListener('input', function(e) {
//   const { value } = this,
//   l = value.length;
//   if(l > 0) {
//     this.style.width = (6 * l) + 'px';
//   }
//   else {
//     this.style.width = '6px';
//   }
// }, false);

// //check enter
// $('ignore-field').addEventListener('keyup', e => {
//   if(e.keyCode === 59 && !!e.target.value.trim()){
//     const { target } = e;
//     let { value } = target;
//     value = value.replace(';', '').trim();
//     const div = document.createElement('div');
//     const txt = document.createTextNode(value.trim());

//     div.className = 'ignore-item';
//     div.title = 'double click to delete';
//     div.dataset.value = value.trim();

//     div.appendChild(txt);

//     target.parentNode.insertBefore(div, target);
//     target.value = '';
//     target.style.width = '6px';

//     const ignoreItems = document.querySelectorAll('.ignore-item');

//     ignoreItems.forEach(div => {
//       div.addEventListener('dblclick', function(){
//         this.parentNode.removeChild(this);
//       }, false);
//     });
//   }
// }, false)
