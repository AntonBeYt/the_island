const CIpicker = document.getElementById('check-in');
const CUpicker = document.getElementById('check-out');
let page = window.location.href;
if (page == 'https://iiwii.se/whirling/index.php') {
  CIpicker.addEventListener('input', () => {
    let pickedCI = CIpicker.value;
    CUpicker.min = pickedCI;
  });
  CUpicker.addEventListener('input', () => {
    let pickedCU = CUpicker.value;
    CIpicker.max = pickedCU;
  });
  document.getElementById('show-addons').addEventListener('click', () => {
    document.getElementById('addons-wrapper').classList.toggle('open');
    document.getElementById('more').classList.toggle('hidden');
    document.getElementById('less').classList.toggle('hidden');
  });
}

function setScroll() {
  let scroll = window.scrollY;
  let scrollString = scroll.toString();
  localStorage.setItem('scrollPosition', scrollString);
}

function restoreScrollPos() {
  if (page == 'https://iiwii.se/whirling/index.php') {
    let posYString = localStorage.getItem('scrollPosition');
    let posY = parseInt(posYString);
    window.scroll(0, posY);
    return true;
  } else {
    localStorage.setItem('scrollPosition', 0);
    return;
  }
}

if (page == 'https://iiwii.se/whirling/success.php') {
  document.getElementById('show-confirmation').addEventListener('click', () => {
    document.getElementById('json-wrapper').classList.toggle('hidden');
  });
}
