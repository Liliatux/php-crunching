<?php 
	$stringDico = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH);
	$dico = explode("\n", $stringDico);
	
	$stringFilm = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
	$brut = json_decode($stringFilm, true);
	$top = $brut["feed"]["entry"]; # liste de films
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Crunching</title>
</head>
<body>
	<h2>Dictionnaire</h2>
	<ol>
		<li>Le dictionnaire contient <?= count($dico); ?> mots</li>
		<li><?php
			$count = 0;
			foreach($dico as $value):
				$len = strlen($value);
				if($len === 15){
					$count++;
				}
			endforeach;
			echo $count;
			?> mots font exactement 15 caractères</li>
		<li><?php 
			$count = 0;
			$w = 'w';
			foreach($dico as $value):
				$wNumber = strpos($value, $w);
				if($wNumber === false){
					echo null;
				} else{ 
					$count++;
				}
			endforeach;
			echo $count;
		?>mots contiennent la lettre « w »</li>
		<li><?php
			$count = 0;
			foreach($dico as $value):
				$qNumber = substr($value,-1);
				if($qNumber === 'q'){
					$count++;
				} else{ 
					null;
				}
			endforeach;
			echo $count;
		?> mots finissent par la lettre « q »</li>
	</ol>
	
	<h2>Film</h2>
	<ol>
		<li>Top 10 des films:<ol>
			<?php for($film = 0; $film < 10; $film++) { ?>
				<li><?php echo $top[$film]['im:name']['label']; ?></li>
			<?php } ?>
		</ol></li>
		<li>Le film "Gravity" est classé
			<?php 
				foreach($top as $value):
					if($value['im:name']['label'] === 'Gravity'){
						echo array_search($value, $top)+1;
					}
				endforeach;
			?>
		</li>
		<li>Le réalisateur du film "The LEGO Movie" est: 
			<?php foreach ($top as $value):
				if($value['im:name']['label'] === 'The LEGO Movie'){
					echo $value['im:artist']['label'];
				}
			endforeach; ?>
		</li>
		<li>Il y a eu 
		<?php 
			$year= 0;
			foreach($top as $value):
				if($value['im:releaseDate']['label'] < 2000){
					$year++;
				}
			endforeach;
			echo $year;
		?> avant 2000</li>
		<li><?php 
			foreach($top as $value):
				$date = $value['im:releaseDate']['label'];
				$film = $value['im:name']['label'];
				$tableDates[$date] = $film;
			endforeach;
			ksort($tableDates); ?>
			Le films le plus récent est <?= end($tableDates);?> et le plus vieux est <?= reset($tableDates); ?>
		</li>
		<li>La catégorie de films la plus représentée est <?php
			$arrayCategory = [];
			foreach($top as $value):
				$nameCategory = $value['category']['attributes']['label'];
				array_push($arrayCategory, $nameCategory);
			endforeach;
			$sameCategories = array_count_values($arrayCategory);
			//trie les valeurs de façon croissante
			asort($sameCategories);
			$bestCategorie = end($sameCategories);
			echo array_search($bestCategorie, $sameCategories);
		?></li>
		<li>Le réalisateur le plus présent dans le top 100 est 
		<?php
			$arrayRealisator = [];
			foreach ($top as $value):
				$realisator = $value['im:artist']['label'];
				array_push($arrayRealisator, $realisator);
			endforeach;
			$sameRealisator = array_count_values($arrayRealisator);
			asort($sameRealisator);
			$bestRealisator = end($sameRealisator);
			echo array_search($bestRealisator, $sameRealisator);
		?></li>
		<li>Acheter le top10 sur iTunes coûterait:
		<?php
			for($film = 0; $film < 10; $film ++){
				$price = $top[$film]['im:price']['attributes']['amount'];
				$priceSum = $priceSum + $price;
			}
			echo $priceSum.'$';
		?>
		<?php 
			for($film = 0; $film < 10; $film++){
				$rental = $top[$film]['im:rentalPrice']['attributes']['amount'];
				$rentalSum = $rental + $rentalSum;
			}
			echo $rentalSum.'$';
		?></li>
		<li>Le mois ayant vu le plus de sorties au cinema est 
		<?php
			$arrayMonth = [];
			foreach($top as $film):
				$date = $film['im:releaseDate']['attributes']['label'];
				$explodeDate = explode(" ", $date);
				array_push($arrayMonth, $explodeDate[0]);
			endforeach;
			$sameMonth = array_count_values($arrayMonth);
			asort($sameMonth);
			$bestMonth = end($sameMonth);
			echo array_search($bestMonth, $sameMonth);
		?></li>
		<li></li>
	</ol>
</body>
</html>
