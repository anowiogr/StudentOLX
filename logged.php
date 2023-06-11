<?php
  session_start();
  print_r($_SESSION["logged"]);
  //print_r(session_status());
  if (!isset($_SESSION["logged"]) || session_status() != 2){
    //print_r($_SESSION["logged"]);
    $_SESSION["role"] = "guest";
    header("location: index.php");
  }else{
    switch ($_SESSION["logged"]["account_type"]){
      case 101:
        $_SESSION["role"] = "admin";
        break;
	    case 222:
          $_SESSION["role"] = "user";
		    break;
    }
    header("location: index.php");
  }

if (isset($_SESSION["logged"]["last_activity"])) {
  $lastActivityTime = $_SESSION["logged"]["last_activity"];
  //echo $lastActivityTime;
  $currentTime = time();
//  $sessionTmeout = 1800; //30 minut
  $sessionTmeout = 60; //1 minuta
  //echo '<br>'.$currentTime;

  if ($currentTime - $lastActivityTime <= $sessionTmeout){
    //echo "Sesja nadal jest aktywna";
  }else{
    //echo "Sesja nieaktywna";
    $_SESSION["error"] = "Sesja zakończona, zaloguj się ponownie";
    header("location: index.php");
    $role = "guest";
  }

  //exit();
}
?>

