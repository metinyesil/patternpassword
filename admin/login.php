<style>
.pattern-lock {
  display: grid;
  grid-template-columns: repeat(3, 50px);
  gap: 44px;
  width: 266px;
  position: relative;
  margin: auto;
}

.dot {
    width: 77px;
    padding: 27px 0px;
    font-family: sans-serif;
    background-color: #161817;
    border-radius: 50%;
    cursor: pointer;
    color: #fff;
    border: 1px solid #60cb4c;
    box-shadow: 0px 0px 10px 0px green;
    text-align: center;
}

.pattern-line {
  position: absolute;
  top: 0;
  left: 0;
  pointer-events: none;
}
body{
  background:url(https://www.itl.cat/pngfile/big/295-2951654_black-and-neon-green-wallpaper-black-and-neon.jpg);
  position: relative;
  margin: auto;
}
span {
    position: relative;
    z-index: 4;
}
</style>
<body>
<meta name="viewport" content="width=device-width, initial-scale=1.0" /><br><br>
  <div class="login" style="position:relative;margin:auto;">
  <center><img width="200" src="img.png"><br><br>
    <div id="alert"></div></center><br>

  <div class="pattern-lock" id="patternLock">
  <div class="dot" id="dot1"><span>1</span></div>
  <div class="dot" id="dot2"><span>2</span></div>
  <div class="dot" id="dot3"><span>3</span></div>
  <div class="dot" id="dot4"><span>4</span></div>
  <div class="dot" id="dot5"><span>5</span></div>
  <div class="dot" id="dot6"><span>6</span></div>
  <div class="dot" id="dot7"><span>7</span></div>
  <div class="dot" id="dot8"><span>8</span></div>
  <div class="dot" id="dot9"><span>9</span></div>
  <svg id="patternLine" class="pattern-line" width="800px" height="800px"></svg>
  </div>
</div>
<br><br>


</body>



<script>
const dots = document.querySelectorAll('.dot');
const patternLine = document.getElementById('patternLine');
let selectedPattern = [];

dots.forEach(dot => {
  dot.addEventListener('click', () => {
    const dotId = dot.id.substring(3); // Remove 'dot' from ID to get the number
    const dotValue = parseInt(dotId);

    if (selectedPattern.includes(dotValue)) {
      // If the dot is already in the pattern, remove it
      const index = selectedPattern.indexOf(dotValue);
      selectedPattern.splice(index, 1);
      dot.style.backgroundColor = '#161817';
    } else {
      // If the dot is not in the pattern, add it
      selectedPattern.push(dotValue);
      dot.style.backgroundColor = 'green';
    }

    updatePatternLine();
    console.log('Selected Pattern:', selectedPattern);
  });
});

function updatePatternLine() {
  patternLine.innerHTML = '';
  if (selectedPattern.length > 1) {
    for (let i = 0; i < selectedPattern.length - 1; i++) {
      const startDot = document.getElementById(`dot${selectedPattern[i]}`);
      const endDot = document.getElementById(`dot${selectedPattern[i + 1]}`);

      const svgLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
      svgLine.setAttribute('x1', startDot.offsetLeft + startDot.offsetWidth / 2);
      svgLine.setAttribute('y1', startDot.offsetTop + startDot.offsetHeight / 2);
      svgLine.setAttribute('x2', endDot.offsetLeft + endDot.offsetWidth / 2);
      svgLine.setAttribute('y2', endDot.offsetTop + endDot.offsetHeight / 2);
      svgLine.setAttribute('stroke', 'green');
      svgLine.setAttribute('stroke-width', '4');
      patternLine.appendChild(svgLine);
    }
  }
}


let timeout;

function sendPattern() {
  clearTimeout(timeout);

  if (selectedPattern.length > 0) {
    timeout = setTimeout(() => {
      const patternToSend = selectedPattern.join('');
      console.log('Sending pattern:', patternToSend);

      // AJAX isteği gönder
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          const response = this.responseText;
          if(response == "success")
          {

            const alertDiv = document.getElementById('alert');

            alertDiv.style.background = '#39d039';
            alertDiv.style.width = '255px';
            alertDiv.style.padding = '10px';
            alertDiv.style.borderRadius = '5px';
            alertDiv.style.fontFamily = 'sans-serif';
            alertDiv.style.border = '1px solid green';
            alertDiv.style.color = '#030303';

            alertDiv.textContent = 'Giriş Başarılı! Yönlendiriliyorsunuz';

            window.location.href = "dashboard.php";

          }
          if(response == "error")
          {

            const alertDiv = document.getElementById('alert');

            alertDiv.style.background = 'rgb(208 57 57)';
            alertDiv.style.width = '255px';
            alertDiv.style.padding = '10px';
            alertDiv.style.borderRadius = '5px';
            alertDiv.style.fontFamily = 'sans-serif';
            alertDiv.style.border = '1px solid maroon';
            alertDiv.style.color = 'rgb(255 255 255)';

            alertDiv.textContent = 'Giriş Başarısız! Lütfen Tekrar deneyin.';

          }
        }
      };
      xhr.open("POST", "ajax.php", true); // Sunucu tarafındaki dosyanın adını ve yolunu buraya yazın
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("pattern=" + patternToSend);
    }, 2000); // 2 saniye bekleme süresi
  }
}

dots.forEach(dot => {
  dot.addEventListener('click', () => {
    // Diğer kodlar...
    updatePatternLine();
    console.log('Selected Pattern:', selectedPattern);
    sendPattern(); // Her buton tıklandığında deseni gönder
  });
});


</script>