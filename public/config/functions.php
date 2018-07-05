<?php
/* AFFICHAGE DES INFORMATIONS */
function refFacture(){
	$i = 1;
    $recu = '';
	while ($i <= 5) {
		$recu = $recu.rand(0, 10);
	    $i++;
	}
	// On prend des nombres ASCII aléatoirement :
	$lettre = rand(65,90);
	// On les transformes en caractère :
	$lettre = chr($lettre);
	echo "<em>Référence: #".$recu.$lettre."</em>";
}

function dateFacture(){
	date_default_timezone_set('Europe/Paris');
	setlocale(LC_TIME, 'fr_FR.utf8','fra');
	// strftime("jourEnLettres jour mois annee") de la date courante
	echo "<em>Date : ".strftime("%A %d %B %Y")."</em>";
						
}



