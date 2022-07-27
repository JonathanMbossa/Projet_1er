<?php
  session_start();

  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    $ipClient = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ipClient = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
    $ipClient = $_SERVER['REMOTE_ADDR'];
  }
  // echo '<p>ip client: '.$ipClient.'</p>';

  $page = $_SERVER['REQUEST_URI'];
  $page = explode('/',$page);
  $page = end($page);

  // echo '<p>page visité: '.$page.'</p>';

  $date1 = date_create();



  function write($page, $date1, $ipClient,$route){
    $date2 = date_create();
    // $date = date_create($date);
    $dates = date_diff($date2, $date1);
    $temps = $dates->format('%h:%i:%s');
    $date1 = date_format($date1,"H:i:s");
    $date2 = date_format($date2,"H:i:s");
    $log = fopen($route, "a+");
    $line = $ipClient ." -- ".$page." -- ".$date1."\n";
    fputs($log, $line);
    fclose($log);
  }

  write($page, $date1, $ipClient,$route);

?>
