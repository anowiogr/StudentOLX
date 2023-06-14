<?php
include_once "constant/header.php";
?>

<body class="d-flex flex-column h-100">

<div class="container prelative text-center">

	<?php
	if(isset($_SESSION["success"]) && $_SESSION["success"]<>null){
		echo "<div class='alert alert-success' role='alert'>$_SESSION[success]</div>";
		$_SESSION["success"]=null;
	}
	?>

	<div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel" data-bs-theme="dark">
		<div class="carousel-indicators">
			<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
			<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
			<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
			<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
			<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="4" aria-label="Slide 5"></button>

		</div>
		<div class="carousel-inner">

			<div class="carousel-item active p-3">
				<svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></svg>
				<div class="container">
					<div class="carousel-caption">
						<h1>KUPUJ I SPRZEDAWAJ JAK LUBISZ</h1>
						<p class="opacity-75">Studencki OLX to super sprawa dla każdego początkującego przedsięciorcy, już dziś zaloguj się i zarób hajsik na cokolwiek chcesz :)</p>
					</div>
				</div>
			</div>
			<?php

			include_once "scripts/connect.php";
			try {
				$stmt = $conn->prepare("SELECT * FROM `auctions` LEFT JOIN `category` ON auctions.`categoryid` = category.`categoryid` WHERE `auctions`.`veryfied` = 1 AND auctions.selled = 0 ORDER BY auctionid DESC LIMIT 4;");
				$stmt->execute();
				$result = $stmt->get_result();

				while ($auction = $result->fetch_assoc()) {
					echo <<< TABLEAUCTION
					<div class="carousel-item p-3">
						<svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></svg>
						<div class="container">
							<div class="carousel-caption" padding="10%">

								<h1>$auction[title]</h1>

								<p><a class="btn btn-lg btn-secondary" href="auction.php?auction_id=$auction[auctionid]">Zobacz ofertę</a></p>
								
							</div>
						</div>
					</div>
			TABLEAUCTION;
				}
			} catch (mysqli_sql_exception $e) {
				$_SESSION["error"] = $e->getMessage();
				echo "error";
				exit();
			}
			$stmt->close();
			?>

		</div>
	</div>



<div class="row p-4">
	<?php

	try {
		$stmt = $conn->prepare("SELECT * FROM `category`");
		$stmt->execute();
		$result = $stmt->get_result();

		while ($category= $result->fetch_assoc()) {
			echo <<< TABLECATEGORY
				<div class="col-lg-4">
					<svg class="bd-placeholder-img rounded-circle" width="60" height="60" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect></svg>
					<h2 class="fw-normal">$category[name]</h2>
				</div>
				
			TABLECATEGORY;
			echo '<br>';
		}
	} catch (mysqli_sql_exception $e) {
		$_SESSION["error"] = $e->getMessage();
		echo "error";
		exit();
	}
	$stmt->close();
	?></div>


</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

<?php
include_once "constant/footer.php";
?>
