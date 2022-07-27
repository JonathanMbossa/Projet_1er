let hiddenState = [0,0,0,0];
function deployBar(id,x){
  let cache = document.getElementById(id);
  if(hiddenState[x] == 0){
    cache.style.display = "block";
    hiddenState[x] = 1;
  } else {
    cache.style.display = "none";
    hiddenState[x] = 0;
  }
}
