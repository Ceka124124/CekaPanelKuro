
 
  <div class="parent">
    <span class="tlt">Copy to Clipboard</span>
    <div class="left">AALYANVIPmoKEY</div>
    <div class="right">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
    </div>
  </div>
  

  
  
  
  <style>
      body{
  font-family: sans-serif;
  color:#111;
  display: flex;
  flex-flow:column;
  background-image: linear-gradient(to top, #cbc9c5 0%, #fadac6 100%);
  height: 100vh;
  overflow: hidden;
  align-items: center;
  justify-content: center;
}

.parent{
  display: flex;
  position: relative;
  font-size: 24px;
  font-weight: bold;
}

.left{
  border: 2px solid;
  border-right:none;
  border-radius:10px;
  border-bottom-right-radius:0;
  border-top-right-radius:0;
  padding: 10px 20px;
}

.right{
  border: 2px solid;
  cursor:pointer;
  border-radius:10px;
  border-left:none;
  border-bottom-left-radius:0;
  border-top-left-radius:0;
  padding: 10px 20px;
  background-image: radial-gradient(circle 248px at center, #16d9e3 0%, #30c7ec 47%, #46aef7 100%);
}

span.tlt{
  display: none;
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(70%);
  background-image: linear-gradient(to top, #c79081 0%, #dfa579 100%);
  padding: 3% 5%;
  border-radius:10px;
  white-space: nowrap;
}
span.tlt.show{
  display: block;
}


h1{
  text-align: right;
  color:#d299c2;
}

  </style>
  
  
  
  <script> 
  let toolt = document.querySelector('.parent');
let span = toolt.querySelector('.tlt');


function showToolTip(e) {
  span.classList.add('show');
  if(e.type == "click") {
    span.innerText = "copied"
    let range = document.createRange();  
    range.selectNode(this.querySelector('.left'));  
    window.getSelection().addRange(range);
    document.execCommand("copy");
  }
}

function hideToolTip() {
  span.classList.remove('show');
  span.innerText = "Copt to Clipboard"
}

toolt.addEventListener('click', showToolTip)
toolt.addEventListener('mouseenter', showToolTip)
toolt.addEventListener('mouseleave', hideToolTip)




  </script> 
