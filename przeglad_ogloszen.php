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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
	</head>

	<nav class="navbar navbar-expand-sm fixed-top navbar-dark bg-dark" style="position: relative;">
                    
            <div class="container">

				<a href="#"><img src="images/icon.png" class="bi" width="40" height="40" /></a>
                            
                <button type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" class="navbar-toggler justify-content-center" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse text-secondary justify-content-end" id="navbar-menu">
                           
                    <ul class="navbar-nav">
						<br /> 
                        <li class="nav-item active">
								<button type="button" class="btn btn-outline-light me-2">Zaloguj</button>
							
						</li>
						<br />
                        <li class="nav-item active">
								<button type="button" class="btn btn-light">Zarejestruj się</button>
						</li>
                    </ul>

                </div>
            </div>
        </nav>

	<body class="d-flex flex-column h-100">

        <br />
		<div class="container" style="position: relative;">
           
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="messageBuy-tab" data-bs-toggle="tab" data-bs-target="#buy" type="button" role="tab" aria-controls="buy" aria-selected="true">Zakupione przedmioty</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="messageSell-tab" data-bs-toggle="tab" data-bs-target="#sell" type="button" role="tab" aria-controls="sell" aria-selected="false">Kupione przedmioty</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="buy" role="tabpanel" aria-labelledby="messageBuy-tab">
                    <br />
                    Twoje zakupy.
                </div>

                <div class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="messageSell-tab">
                    <br />
                    Twoje sprzedane produkty.
                </div>
            </div>

        </div>


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