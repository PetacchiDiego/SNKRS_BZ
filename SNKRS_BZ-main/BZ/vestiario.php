<?php
	include("connect.php");
	// Imposta il numero di risultati per pagina
	$results_per_page = 48;

	// Calcola il numero totale di risultati nel database
	$sql_total = "SELECT COUNT(id) AS total FROM item where tipologia=2";
	$result_total = eseguiquery($sql_total);
	$total_results = $result_total[0]['total'];

	// Calcola il numero totale di pagine
	$total_pages = ceil($total_results / $results_per_page);

	// Determina la pagina corrente dall'URL, se non è impostata, usa la pagina 1
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$page = max(1, min($page, $total_pages)); // Assicura che la pagina sia nel range valido

	// Calcola il limite di partenza per la query
	$start_limit = ($page - 1) * $results_per_page;

	// Esegui la query per ottenere i risultati per la pagina corrente
	$sql = "select i.* FROM item i where tipologia=2 LIMIT $start_limit, $results_per_page";
	$data = eseguiquery($sql);
	//print_r($data);


  	$html = ""; 
  	for($i = 0;$i < count($data);$i++){
    
		$nome=$data[$i]["nome"];
		
		if(strlen($nome)>15){
		$nome=substr($data[$i]["nome"], 0, 15)."...";
		}
		if($data[$i]["idSito"] == 1) {
			$srcLogo = "images/LogoSite/hyperboost.png";
		} if($data[$i]["idSito"]== 2) {
			$srcLogo = "images/LogoSite/droplist.png";
		}
		if($data[$i]["idSito"]== 3) {
			$srcLogo = "images/LogoSite/naked.png";
		}

		$html.="
			<div class='col-sm-6 col-md-4 col-lg-3'>
			<div class='box'>
				<a href='".$data[$i]["link"]."'>
				<div class='img-box'>
					<img src={$data[$i]["linkImg"]} alt='errore'>
				</div>
				<div class='detail-box'>
					<h6> {$nome}</h6>
					<h6>
					Price
					<span>
					". $data[$i]["prezzo"]."
					</span>
					</h6>
				</div>
				<div >
					<span class='new'>
					<img src={$srcLogo} style='width:70%'>
					</span>
				</div>
				</a>
			</div>
			</div>";

  	}




?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">

  <title>
    vestiario
  </title>

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <link rel="stylesheet" type="text/css" href="css/bootstrap.css?ts=<?php echo time(); ?>" />
  <link href="css/style.css?ts=<?php echo time(); ?>" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body>
  <!-- primo widget -->
	<div class="hero_area">
		
		<!-- sezione header -->
		<header class="header_section">
		  <nav class="navbar navbar-expand-lg custom_nav-container ">
			<a class="navbar-brand" href="home.php">
			  <span>
				snkrs BZ
			  </span>
			</a>
			
			<!-- menu -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class=""></span>
			</button>

			<div class="collapse navbar-collapse  innerpage_navbar" id="navbarSupportedContent">
			  <ul class="navbar-nav  ">
				<li class="nav-item">
				  <a class="nav-link" href="home.php">Home</span></a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="sneaker.php">
					Sneakers 
				  </a>
				</li>
				<li class="nav-item active">
				  <a class="nav-link" href="vestiario.php">
					Vestiario <span class="sr-only">(current)
				  </a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="outfit.php">
					Outfit
				  </a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="recensioni.php">
					Recensioni
				  </a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="chi-siamo.php">Chi siamo</a>
				</li>
			  </ul>
			</div>
		  </nav>
		</header>

	</div>


  <section class="shop_section layout_padding">
		<div class="container">
			<div class="heading_container heading_center">
				<div class="topnav">
					<form method="GET" action="vestiarioRicerca.php">
						<input type="text" placeholder="Cerca.." name="search">
						<button type="submit" ><i class="fa fa-search"></i></button>
					</form>
				</div>
			</div>
			<div class="row">
				
				<?php echo $html ?>
			</div>
			<div class="pagination">
				<span>Page</span>
				<select onchange="location = this.value;">
				<?php
					for ($i = 1; $i <= $total_pages; $i++) {
						$selected = ($i == $page) ? 'selected' : '';
						echo "<option value='vestiario.php?page=$i' $selected>$i</option>";
						}
					?>
				</select>
				<span>of <?php echo $total_pages; ?></span>
				<?php if ($page < $total_pages) { ?>
					<a href="sneaker.php?page=<?php echo $page + 1; ?>">Next</a>
				<?php } ?>
			</div>
		</div>
 	</section>


	<!-- footer -->
	<section class="info_section  layout_padding2-top">
		<div class="info_container ">
		  <div class="container">
			<div class="row">
			  <div class="col-md-6 col-lg-3">
				
			  </div>
			  <div class="col-md-6 col-lg-3">
				<h6 style="text-align: center;">
				  CHI SIAMO
				</h6>
				<p>
					La nostra passione per la moda e la tecnologia ci ha spinto a creare un'esperienza di shopping online senza precedenti per gli amanti delle sneakers e dello stile.				</p>
			  </div>
			  <div class="col-md-6 col-lg-3">
				<h6 style="text-align: center;">
				  CONTATTI
				</h6>
				<div class="info_link-box">
				  <a href="">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<span> Via Makallè, 12, 42124 Reggio Emilia RE </span>
				  </a>
				  <a href="">
					<i class="fa fa-phone" aria-hidden="true"></i>
					<span>3333090567</span>
				  </a>
				  <a href="">
					<i class="fa fa-envelope" aria-hidden="true"></i>
					<span>matteo.soncini@studenti.iispascal.it</span>
				  </a>
				  <a href="">
					<i class="fa fa-envelope" aria-hidden="true"></i>
					<span>diego.petacchi@studenti.iispascal.it</span>
				  </a>
				</div>
			  </div>
			  <div class="col-md-6 col-lg-3">
				
			  </div>
			</div>
		  </div>
		</div>
		<footer class=" footer_section">
		  <div class="container">
			<p>
			  Sito creato da snkrsBZ s.r.l.
			</p>
		  </div>
		</footer>
	</section>


  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <script src="js/custom.js"></script>

</body>

</html>