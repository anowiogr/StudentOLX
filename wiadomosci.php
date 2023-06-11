<?php
include_once "constant/header.php"
?>


<body class="d-flex flex-column h-100">

        <br />
		<div class="container prelative">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="messageBuy-tab" data-bs-toggle="tab" data-bs-target="#buy" type="button" role="tab" aria-controls="buy" aria-selected="true">Kupujesz</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="messageSell-tab" data-bs-toggle="tab" data-bs-target="#sell" type="button" role="tab" aria-controls="sell" aria-selected="false">Sprzedajesz</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="buy" role="tabpanel" aria-labelledby="messageBuy-tab">
                    <br />



                </div>

                <div class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="messageSell-tab">
                    <br />



                </div>
            </div>

        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
	</body>

<?php
include_once "constant/footer.php"
?>
