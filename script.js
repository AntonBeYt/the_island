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
