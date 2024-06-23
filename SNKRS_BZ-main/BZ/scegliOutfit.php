<?php
	include("connect.php");

	$data1=null;

	//stampa scarpa selezionata
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		
		if (isset($_GET['search'])) {
			
			$id = $_GET['search'];

			$sql1="select *
					from item
					where id='$id'";

			$data1=eseguiquery($sql1);
			//print_r($data);
			$html1 = ""; 
			
			$nome=$data1[0]["nome"];
			
			if(strlen($nome)>40){
				$nome=substr($data1[0]["nome"], 0, 35)."...";
			}

			if($data1[0]["idSito"]==1){
				$html1.="
				<div class='col-sm-6 col-md-4 col-lg-3'>
				<div class='box1'>
					<div class='img-box'>
						<img src={$data1[0]["linkImg"]} alt='errore'>
					</div>
					<div class='detail-box'>
						<h6> {$nome}</h6>
						<h6>
						</h6>
					</div>
					<div >
						<span class='new1'>
						Scarpa selezionata
						</span>
					</div>
				</div>
				</div>
				";
			}

			
		}
		
	}


	
	//funzione estrazione colore dominante
	function getDominantColorFromURL($url, $tolerance) {
		// Scaricare l'immagine dal link usando cURL
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$imageData = curl_exec($ch);
		curl_close($ch);
		if ($imageData === FALSE) {
			return false;
		}
	
		// Creare l'immagine dalla stringa di dati binari
		$image = imagecreatefromstring($imageData);
	
		if (!$image) {
			return false;
		}
	
		$width = imagesx($image);
		$height = imagesy($image);
	
		$colors = [];
	
		// Iterare su ogni pixel
		for ($x = 0; $x < $width; $x++) {
			for ($y = 0; $y < $height; $y++) {
				$rgb = imagecolorat($image, $x, $y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
	
				// Ignora pixel bianchi o quasi bianchi
				if ($r <= $tolerance && $g <= $tolerance && $b <= $tolerance) {
					$colors[] = $rgb;
				}
			}
		}
	
		if (empty($colors)) {
			return false;  // Ritorna false se tutti i pixel erano bianchi
		}
	
		// Conta le occorrenze di ogni colore
		$colorCounts = array_count_values($colors);
	
		// Trova il colore dominante
		arsort($colorCounts);
		$dominantColor = array_key_first($colorCounts);
	
		// Decomporre il colore RGB
		$r = ($dominantColor >> 16) & 0xFF;
		$g = ($dominantColor >> 8) & 0xFF;
		$b = $dominantColor & 0xFF;
	
		return ['r' => $r, 'g' => $g, 'b' => $b];
	}

	//funzione per calcolo della distanza tra due colori
	function colorSimilarity($color1, $color2) {
		$r1 = $color1['r'];
		$g1 = $color1['g'];
		$b1 = $color1['b'];
	
		$r2 = $color2['r'];
		$g2 = $color2['g'];
		$b2 = $color2['b'];
	
		// Calcolo della distanza Euclidea
		$distance = sqrt(
			pow($r1 - $r2, 2) +
			pow($g1 - $g2, 2) +
			pow($b1 - $b2, 2)
		);
	
		return $distance;
	}
	
	
	$imageUrl = trim($data1[0]['linkImg']);
	//echo "URL immagine: " . $imageUrl . "<br>";

	//funzione estrazione colore dominante escludento il colore 254 per lo sfondo
	$dominantColorScarpa = getDominantColorFromURL($imageUrl, 245);
	//print_r($dominantColorScarpa);

	if ($dominantColorScarpa==false) {
		echo "Impossibile scaricare o elaborare l'immagine.";
	} else {
		$sql = "select * from item where tipologia=2";
		$data3 = eseguiquery($sql);

		// Array per memorizzare i colori simili e opposti
		$arrayColoriSimili = [];
		$arrayColoriOpposti = [];

		
		$maxSimilarItems = 5;
		$html3 = "";
		
		for ($i = 0; $i < count($data3); $i++) {
			$d = $data3[$i]['color'];

			// Rimozione delle parentesi quadre
			$d = str_replace(['[', ']'], '', $d);

			// Rimozione degli spazi iniziali e finali e suddivisione usando preg_split per gestire spazi multipli
			$d = trim($d);
			$rgbArray = preg_split('/\s+/', $d);

			if (count($rgbArray) === 3) {
				list($r, $g, $b) = $rgbArray;
				$colorArray = [
					'r' => $r,
					'g' => $g,
					'b' => $b
				];

				$distance = colorSimilarity($dominantColorScarpa, $colorArray);

				// Creazione dell'array per i colori
				$arrayColor = [
					'distance' => $distance,
					'id' => $data3[$i]["id"],
					'nome' => $data3[$i]["nome"],
					'prezzo' => $data3[$i]["prezzo"],
					'linkImg' => $data3[$i]["linkImg"],
					'link' => $data3[$i]["link"],
					'idSito' => $data3[$i]["idSito"]
				];

				//CALCOLO I COLORI SIMILI
				if (count($arrayColoriSimili) < $maxSimilarItems) {
					$arrayColoriSimili[] = $arrayColor;
				} else {
					// Trova il valore massimo di distanza
					$maxIndex = -1;
					$maxDistance = -1;
					foreach ($arrayColoriSimili as $index => $simile) {
						if ($simile['distance'] > $maxDistance) {
							$maxDistance = $simile['distance'];
							$maxIndex = $index;
						}
					}
					
					// Sostituisci se la distanza corrente è minore della distanza massima trovata
					if ($distance < $maxDistance) {
						$arrayColoriSimili[$maxIndex] = $arrayColor;
						
					}
				}

				//CALCOLO IL COLORE OPPOSTO A QUELLO DELLA SCARPA E GUARDO QUALI COLORI SONO PIU VICINI
				$colorOppostoArray = [
					'r' => 255-$dominantColorScarpa['r'],
					'g' => 255-$dominantColorScarpa['g'],
					'b' => 255-$dominantColorScarpa['b']
				];
				$distance2 = colorSimilarity($colorOppostoArray, $colorArray);
	
				if (count($arrayColoriOpposti) < $maxSimilarItems) {
					$arrayColoriOpposti[] = $arrayColor;
				} else {
					// Trova il valore massimo di distanza
					$maxIndex = -1;
					$maxDistance = -1;
					foreach ($arrayColoriSimili as $index => $simile) {
						if ($simile['distance'] > $maxDistance) {
							$maxDistance = $simile['distance'];
							$maxIndex = $index;
						}
					}
					// Sostituisci se la distanza corrente è minore della distanza massima trovata
					if ($distance2 < $maxDistance) {
						$arrayColoriOpposti[$maxIndex] = $arrayColor;
					}
				}
			} else {
				echo "Errore nella stringa colore per: ".$d."<br>";
			}
		}
		
		//STAMPO VALORI DEI ITEM CON COLORE SIMILE
		for($i=0;$i<count($arrayColoriSimili);$i++) {
			$nome = $arrayColoriSimili[$i]["nome"];

			if (strlen($nome) > 15) {
				$nome = substr($arrayColoriSimili[$i]["nome"], 0, 15) . "...";
			}

			$srcLogo = "";
			if ($arrayColoriSimili[$i]["idSito"] == 1) {
				$srcLogo = "images/LogoSite/hyperboost.png";
			} elseif ($arrayColoriSimili[$i]["idSito"] == 2) {
				$srcLogo = "images/LogoSite/droplist.png";
			} elseif ($arrayColoriSimili[$i]["idSito"] == 3) {
				$srcLogo = "images/LogoSite/naked.png";
			}

			$html3 .= "
				<div class='col-sm-6 col-md-4 col-lg-3'>
					<div class='box'>
						<a href='" . $arrayColoriSimili[$i]["link"] . "'>
							<div class='img-box'>
								<img src='" . $arrayColoriSimili[$i]["linkImg"] . "' alt='errore'>
							</div>
							<div class='detail-box'>
								<h6>$nome</h6>
								<h6>
									Price
									<span>" . $arrayColoriSimili[$i]["prezzo"] . "</span>
								</h6>
							</div>
							<div>
								<span class='new'>
									<img src='$srcLogo' style='width:70%'>
								</span>
							</div>
						</a>
					</div>
				</div>";
		}

		//STAMPO VALORI DEI ITEM CON COLORE OPPOSTO
		for($i=0;$i<count($arrayColoriOpposti);$i++) {
			$nome = $arrayColoriOpposti[$i]["nome"];

			if (strlen($nome) > 15) {
				$nome = substr($arrayColoriOpposti[$i]["nome"], 0, 15) . "...";
			}

			$srcLogo = "";
			if ($arrayColoriOpposti[$i]["idSito"] == 1) {
				$srcLogo = "images/LogoSite/hyperboost.png";
			} elseif ($arrayColoriOpposti[$i]["idSito"] == 2) {
				$srcLogo = "images/LogoSite/droplist.png";
			} elseif ($arrayColoriOpposti[$i]["idSito"] == 3) {
				$srcLogo = "images/LogoSite/naked.png";
			}

			$html3 .= "
				<div class='col-sm-6 col-md-4 col-lg-3'>
					<div class='box'>
						<a href='" . $arrayColoriOpposti[$i]["link"] . "'>
							<div class='img-box'>
								<img src='" . $arrayColoriOpposti[$i]["linkImg"] . "' alt='errore'>
							</div>
							<div class='detail-box'>
								<h6>$nome</h6>
								<h6>
									Price
									<span>" . $arrayColoriOpposti[$i]["prezzo"] . "</span>
								</h6>
							</div>
							<div>
								<span class='new'>
									<img src='$srcLogo' style='width:70%'>
								</span>
							</div>
						</a>
					</div>
				</div>";
		}
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
				<?php echo $html3; ?>
			</div>
			<div class="btn-box" style="align: center">
            	<a href="outfit.php">
            	 	Back to all 
        	    </a>
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