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
			
		</li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ol>
</body>
</html>
