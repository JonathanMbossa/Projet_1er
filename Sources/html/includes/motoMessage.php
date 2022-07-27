<?php
  if(isset($_GET["message"]) && !empty($_GET["message"])){
    echo "<div id=motoMessage>
            <div id='motoMsg'>
              <img src='".$path."MotoBanderole.png'>
              <small>".$_GET["message"]."</small>
            </div>
          </div>";
  }
?>

<style>
  div#motoMessage > div > small{
    font-family: cursive;
    position: absolute;
    margin-top: 3.6vh;
    margin-left: 2.7vw;
    max-width: 15vw;
  }
  div#motoMessage{
    position: absolute;
    width: 99%;
  }

  div#motoMsg{
    display:none;
    margin-left:auto;
    transition: all 4s;
    width: min-content;
    position: relative;
    z-index:10;
  }


</style>

<script>
  const doc = document.getElementById("motoMsg");

  doc.style.marginRight = "100%";
  doc.style.display = "flex";
  setTimeout(setMargin,200);
  setTimeout(setNone,4200);

  function setMargin(){
    doc.style.marginRight = "0px";
  }
  function setNone(){
    doc.style.display = "none";
  }

</script>
