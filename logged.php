<?php
  session_start();
  if (!isset($_SESSION["logged"]) || session_status() != 2){
    //print_r($_SESSION["logged"]);
    header("location: ./");
  }else{
    switch ($_SESSION["logged"]["role_id"]){
      case 1:
	      $role = "logged_user";
        break;
	    case 2:
		    $role = "logged_moderator";
		    break;
	    case 3:
		    $role = "logged_admin";
		    break;
    }
  }

if (isset($_SESSION["logged"]["last_activity"])){
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
    header("location: ./");
  }

  //exit();
}
?>

