<?php
session_start();
//print_r($_POST);

foreach ($_POST as $value){
	if (empty($value)){
		$_SESSION["error"] = "Wypełnij wszystkie dane!";
		echo "<script>history.back();</script>";
		exit();
	}
}

require_once "./connect.php";

try {
	$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
	$stmt->bind_param("s", $_POST["email"]);
	$stmt->execute();

	$result = $stmt->get_result();
	//echo $result->num_rows;

	if ($result->num_rows != 0){
		//$_SESSION["success"] = "Prawidłowo zalo użytkownika $_POST[firstName] $_POST[lastName]";
		// "email istnieje";

		$user = $result->fetch_assoc();
		$stmt->close();
		//print_r($user);
		if (password_verify($_POST["pass"], $user["password"])){
			$_SESSION["logged"]["firstName"] = $user["firstName"];
			$_SESSION["logged"]["lastName"] = $user["lastName"];
			$_SESSION["logged"]["session_id"] = session_id();
			//echo $_SESSION["logged"]["session_id"];
			//echo  session_status();
			$_SESSION["logged"]["role_id"] = $user["role_id"];
			$_SESSION["logged"]["last_activity"] = time();
			//print_r($_SESSION["logged"]);
			header("location: ../pages/logged.php");
		}else{
			$_SESSION["error"] = "Nie udało się zalogować!";
			echo "<script>history.back();</script>";
		}

		//header("location: ???");
	}else{
		echo "brak adresu email w bazie!";
	}
} catch (mysqli_sql_exception $e) {
	$_SESSION["error"] = $e->getMessage();
	//echo "<script>history.back();</script>";
	echo "error";
	exit();
}