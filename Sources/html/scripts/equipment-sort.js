const count = document.getElementsByClassName("col-md-3 col-sm-6"); // Compte le nombre total d'éléments sur la page
//console.log(count.length);
const sortNumber = (a,b) => a - b;

function sortType(x){
  for(let i = 0; i < count.length; i++){
    //console.log("test: ",test,"     count[",i,"]:  ",count[i]);
    let splitType = count[i].id.split("-");
    if(x != splitType[0]){ // verif que l'id est le même, l'id représente le type d'équipement
      count[i].style.display = "none"; // Cache l'élément s'il n'a pas le même id
    } else {
      count[i].style.display = "block"; // Affiche l'élément s'il a le même id
    }
  }
}

function sortMark(x){
  for(let i = 0; i < count.length; i++){
    //console.log("test: ",test,"     count[",i,"]:  ",count[i]);
    let splitType = count[i].id.split("-");
    if(x != splitType[1]){ // verif que l'id est le même, l'id représente le type d'équipement
      count[i].style.display = "none"; // Cache l'élément s'il n'a pas le même id
    } else {
      count[i].style.display = "block"; // Affiche l'élément s'il a le même id
    }
  }
}

function sortPriceAscend(){ // Tri par prix croissant
  let splitPrice;
  for(let i = 0; i < count.length; i++){
    splitPrice = count[i].id.split("-"); // Découpe l'id
    count[i].style.order = parseInt(splitPrice[3]); // Défini l'attribut CSS order en function du prix, parseInt() permet de convertir un text en numbre et la 3eme case du tableu splitPrice contient le prix
  }
}

function sortPriceDescend(){
  let splitPrice;
  for(let i = 0; i < count.length; i++){
    splitPrice = count[i].id.split("-"); // Découpe l'id
    count[i].style.order = -parseInt(splitPrice[3]); // Défini l'attribut CSS order en function du prix, parseInt() permet de convertir un text en numbre et la 3eme case du tableu splitPrice contient le prix
  }
}


function sortPriceBetween(){
  let min = document.getElementById("sortMin").value; // Récupère la val min sur la page html
  let max = document.getElementById("sortMax").value; // Récupère la val mac sur la page html
  let priceArray = [];
  let splitPrice;
  for(let i = 0; i < count.length; i++){
    splitPrice = count[i].id.split("-"); // split l'id pour ensuite récupe la partie prix
    // console.log(parseInt(splitPrice[3])," ==== min: ",parseInt(min)," ==== max: ",parseInt(max));
    if(parseInt(splitPrice[3]) >= parseInt(min) && parseInt(splitPrice[3]) <= parseInt(max)){ // vérif que le prix recup est bien entre min et max donnée
      count[i].style.display = "block"; // si oui on affiche
    } else {
      count[i].style.display = "none"; // sinon on cache
    }
  }
}

function sortAlphabetic(){
  let alphabeticArray = [];
  let splitModel;
  for(let i = 0; i < count.length; i++){
    splitModel = count[i].id.split("-"); // split l'id pour recup le model
    alphabeticArray.push(splitModel[2]); // ajoute au tableau le model
  }
  alphabeticArray = alphabeticArray.sort(); // tri dans l'ordre alphabétique les modèle entrer dans le tableau
  for(let i = 0; i < count.length; i++){
    splitModel = count[i].id.split("-"); // split l'id pour recup le model
    for(let y = 0; y < alphabeticArray.length; y++){
      // console.log(splitModel[2],"  ===  ",alphabeticArray[y]," === ",i)
      if(splitModel[2] == alphabeticArray[y]){
        count[y].style.order = i; // si les modèles corresondent,on donne un attribut order de i
      }
    }
  }
}

function sortUnalphabetic(){
  let alphabeticArray = [];
  let splitModel;
  for(let i = 0; i < count.length; i++){
    splitModel = count[i].id.split("-"); // split l'id pour recup le model
    alphabeticArray.push(splitModel[2]); // ajoute au tableau le model
  }
  alphabeticArray = alphabeticArray.sort(); // tri dans l'ordre alphabétique les modèle entrer dans le tableau
  for(let i = 0; i < count.length; i++){
    splitModel = count[i].id.split("-"); // split l'id pour recup le model
    for(let y = 0; y < alphabeticArray.length; y++){
      // console.log(splitModel[2],"  ===  ",alphabeticArray[y]," === ",i)
      if(splitModel[2] == alphabeticArray[y]){
        count[y].style.order = -i; // si les modèles corresondent,on donne un attribut order de i mais négative pour inverser la liste finale
      }
    }
  }
}

function sortSearchBar(){
  let splitId;
  let str = document.getElementById("sortSearch").value;
  for(let i = 0; i < count.length; i++){
    splitId = count[i].id.split("-"); // split l'id pour recup le model
    // console.log(splitId[1]," === ",splitId[1].indexOf(str), " === ",splitId[2].indexOf(str));
    if(splitId[1].indexOf(str) >= 0 || splitId[2].indexOf(str) >= 0){
      count[i].style.display = "block";
    } else {
      count[i].style.display = "none";
    }
  }
}


function resetFilter(){
  for(let i = 0; i < count.length; i++){
    count[i].style.display = "block"; // Affiche tout les éléments de la page
    count[i].style.order = 0; // reset l'ordre des éléments
  }
}
