<!doctype html>
<html class="h-100">
	<head>
		<meta charset="utf-8">
		<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta name="description" 
			  content="Strona stworzona w celach nauki programowania www. Studencki OLX to strona stworzona, aby przećwiczyć tworzenie kodu w HTML|PHP|JavaScript w powiązaniu z SQL.">
		<link rel="icon" 
			  type="image/png" href="images/favicon.ico">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
			  rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">

		<title>Studencki OLX</title>

	</head>

	<nav class="navbar navbar-expand-sm fixed-top navbar-dark bg-dark">
                    
            <div class="container">

				<a href="#"><img src="images/icon.png" class="bi" width="40" height="40" /></a>
                            
                <button type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" class="navbar-toggler justify-content-center" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse text-secondary justify-content-end" id="navbar-menu">
                           
                    <ul class="navbar-nav">
						<br /> 
                        <li class="nav-item active">
							<a href="login.php">
								<button type="button" class="btn btn-outline-light me-2">
									Zaloguj
								</button>
							</a>
						</li>
						<br />
                        <li class="nav-item active">
							<a href="register.php">
								<button type="button" class="btn btn-light">
									Zarejestruj się
								</button>
							</a>
						</li>
                    </ul>

                </div>
            </div>
        </nav>

	<body class="d-flex flex-column h-100">
	

	<?php
require 'scripts/connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_POST['user_id'];

        $query = "SELECT accounts.*, type.type_name
                  FROM accounts
                  LEFT JOIN type ON accounts.account_type = type.type_id
                  WHERE userid = :userid";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':userid', $userId);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "<h2>Informacje o użytkowniku</h2>";
            echo "<p>ID: " . $user['accountid'] . "</p>";
            echo "<p>Login: " . $user['login'] . "</p>";
            echo "<p>Typ konta: " . $user['type_name'] . "</p>";
            echo "<p>Zweryfikowany: " . ($user['verified'] ? 'Tak' : 'Nie') . "</p>";
            // Wyświetlanie pozostałych informacji dotyczących użytkownika
            // ...
        } else {
            echo "Użytkownik o podanym ID nie został znaleziony.";
        }
    }
} catch (PDOException $e) {
    die("Błąd połączenia lub tworzenia bazy danych: " . $e->getMessage());
}
?>

<h2>Wyszukaj użytkownika</h2>
<form method="POST" action="">
    <label for="user_id">ID użytkownika:</label>
    <input type="text" name="user_id" id="user_id" required>
    <button type="submit">Szukaj</button>
</form>




		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
	</body>

	<footer class="mt-auto bg-dark">
        <div class="container">
            <div class="p-2 mb-1 col-lg-12 text-secondary">
                 © Created by: Iwona Ogrodowska, Karolina Małecka, Łukasz Bielski
            </div>
        </div>
    </footer>

</html>