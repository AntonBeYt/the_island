const CIpicker = document.getElementById('check-in');
const CUpicker = document.getElementById('check-out');
CIpicker.addEventListener('input', () => {
  let pickedCI = CIpicker.value;
  CUpicker.min = pickedCI;
});
CUpicker.addEventListener('input', () => {
  let pickedCU = CUpicker.value;
  CIpicker.max = pickedCU;
});

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

document.getElementById('show-addons').addEventListener('click', () => {
  document.getElementById('addons-wrapper').classList.toggle('open');
  document.getElementById('more').classList.toggle('hidden');
  document.getElementById('less').classList.toggle('hidden');
});
