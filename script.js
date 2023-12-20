const CIpicker = document.getElementById('check-in');
const CUpicker = document.getElementById('check-out');
if (window.location.pathname == '/index.php') {
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
  let posYString = localStorage.getItem('scrollPosition');
  let posY = parseInt(posYString);
  window.scroll(0, posY);
  return true;
}

if (window.location.pathname == '/success.php') {
  document.getElementById('show-confirmation').addEventListener('click', () => {
    document.getElementById('json-wrapper').classList.toggle('hidden');
  });
}
