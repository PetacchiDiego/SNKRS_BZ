<?php
	include("connect.php");

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		
		if (isset($_GET['search'])) {
			
			$name = $_GET['search'];

			$sql1="select i.idItem, i.nome, ins.linkScarpa, ins.prezzoMedio, immg.imgPath, s.idSito, scarp.idScarpa
			from item i
			inner join inserita ins on i.idItem=ins.FK_idItem
			inner join immagini immg on immg.FK_idItem=i.idItem
			inner join siti s on s.idSito=ins.FK_idSito
			inner join scarpe scarp on scarp.FK_idItem=i.idItem
			where i.nome like '%$name%'";

			$data=eseguiquery($sql1);
			//print_r($data);
			$html1 = ""; 
			for($i = 0;$i < count($data);$i++){
			
			$nome=$data[$i]["nome"];
			
			if(strlen($nome)>40){
			$nome=substr($data[$i]["nome"], 0, 40)."...";
			}

			if($data[$i]["idSito"]==1){
				$html1.="
				<div class='col-sm-6 col-md-4 col-lg-3'>
				<div class='box'>
					<a href='".$data[$i]["linkScarpa"]."'>
					<span>
						Scarpa selezionata
					</span>
					<div class='img-box'>
						<img src={$data[$i]["imgPath"]} alt='errore'>
					</div>
					<div class='detail-box'>
						<h6> {$nome}</h6>
						<h6>
						</h6>
					</div>
					
					</a>
				</div>
				</div>";
			}

			}
		}}
		
	$sql="select i.idItem, i.nome, ins.linkScarpa, ins.prezzoMedio, immg.imgPath, s.idSito, vest.idVestiario
	from item i
	inner join inserita ins on i.idItem=ins.FK_idItem
	inner join immagini immg on immg.FK_idItem=i.idItem
	inner join siti s on s.idSito=ins.FK_idSito
	inner join vestiario vest on vest.FK_idItem=i.idItem";

	$data=eseguiquery($sql);
	//print_r($data);
	$html = ""; 
	for($i = 0;$i < count($data);$i++){
		
		$nome=$data[$i]["nome"];
		
		if(strlen($nome)>15){
		$nome=substr($data[$i]["nome"], 0, 15)."...";
		}

		if($data[$i]["idSito"]==1){
		$srcLogo="images/LogoSite/logoStokX.png";
		}
		else{
		$srcLogo="images/LogoSite/logoKlekt.png";
		}

		$html.="
			<div class='col-sm-6 col-md-4 col-lg-3'>
			<div class='box'>
				<a href='".$data[$i]["linkScarpa"]."'>
				<div class='img-box'>
					<img src={$data[$i]["imgPath"]} alt='errore'>
				</div>
				<div class='detail-box'>
					<h6> {$nome}</h6>
					<h6>
					Price
					<span>
					". $data[$i]["prezzoMedio"]."
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
    outfit
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
					Sneakers <span class="sr-only">
				  </a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="vestiario.php">
					Vestiario
				  </a>
				</li>
                <li class="nav-item active">
				  <a class="nav-link" href="outfit.php">
					Outfit <span class="sr-only">(current)
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
                <p> Qui puoi trovare la scarpa da te selezionata e i vestiti da poterci abbinare, sbizzarrisciti !!!</p>
				</div>
			</div>
			<div class="row">
				<?php echo $html1; ?>
				<?php echo $html; ?>
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