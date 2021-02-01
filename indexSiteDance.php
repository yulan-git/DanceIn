<?php
require 'elements/header.php';
require_once 'functions.php';
require_once 'config.php';

?>

<body>
	<header class="topbar">
		<a href="indexSiteDance.php">
			<img src="css/img/logo2.jpg" class="logo">
		</a>
		<nav class="menu">
			<?= nav_menu('nav-link') ?>
		</nav>
	</header>
	<!-- end header-->

	<!-- content-->
	<div class="font">
		<div class="content">
			<div class="form-title">
				<h2>Envie de danser !</h2>
			</div>

			<div class="container">
				<div class="row">
					<!-- place-line1 input-->
					<div class="form-block col-4">
						<div class="form-about">
							<label for="categorie" class="style">Quoi</label>
							<?= select('cat', $categorie, CATEGORIE) ?>
						</div>

						<div class="form-about">
							<label for="style" class="style">Style</label>
							<?= select('style', $style, STYLE) ?>
						</div>

						<div class="form-about">
							<label for="niveau" class="niveau">Niveau</label>
							<?= select('niv', $niveau, NIVEAU) ?>
						</div>

						<div class="form-about">
							<label for="appt">Date de début</label>
							<input type="dateTime-local" class="form-control" id="dteTimeDebut" name="dateTimeDebut">
						</div>
						<div class="form-about">
							<label for="appt">Date de fin</label>
							<input type="datetime-local" class="form-control" id="dteTimeFin" name="dateTimeFin">
						</div>

						<div class="form-about">
							<label for="lieu">Lieu</label>
							<input id="champ-adresse" type="text" class="form-control">
							<div class="input-group-append" id="button-addon4">
								<button id="button-geo" class="btn btn-outline-secondary" type="submit">
									<span class="sr-only">Ma position</span>
									<i class="fas fa-location-arrow"></i></button>
							</div>
						</div>
						<div class="form-about">
							<label for="champs-distance">Distance : </label>
							<div id="valeur-distance"></div>
							<input type="range" min="1" max="30" id="champs-distance" name="distance" class="form-control">
						</div>

						<div class="form-about">
							<button tyrpe="submit" class="btn btn-primary bouton" name="submit" id="submit" value="Rechercher">Rechercher</button>
						</div>
					</div>


					<div class="form-block col-8">
						<!-- Map-->
						<div id="map" class="map"></div>
						<!-- end Map-->
					</div>

					<div class="form-block col">
						<div class="form-about cadre">
							<h4>Liste des évènements recherchés : </h4>
							<div id="event"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end content-->

	<!-- footer -->
	<?php
	require 'elements/footer.php';
