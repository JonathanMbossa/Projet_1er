const arr = ["../img/photo5.jpg","../img/photo10.jpg","../img/photo11.jpg","../img/photo6.jpg","../img/photo7.jpg"];
let pictureIndex=0;
const image= document.getElementById('image');
image.src = arr[pictureIndex];


function next(){
  pictureIndex++;
  if (pictureIndex>4) {
    pictureIndex=0;
  }
  image.src = arr[pictureIndex];
  }



function previous(){
  pictureIndex--;
  if (pictureIndex<0) {
    pictureIndex=4;
  }
   image.src = arr[pictureIndex];
  }

  /**
  setInterval permet de déclencher une fonction toutes les N millis
  - 1er parametre: function
  - 2eme: Le nombre millis entre chaque call
  */
  setInterval(next, 3500);
