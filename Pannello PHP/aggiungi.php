<?php 
		$db = new mysqli("localhost", "root", "onslario89", "test", 3306);
			
				if ($db->connect_errno) {
					echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				}
		
		$nome = $_POST['nome']; 
		$prezzo = $_POST['prezzo']; 
		$mutuabile = $_POST['mutuabile']; 
		$giorni_totali = $_POST['giorni_totali']; 
		$quantita_giornaliera = $_POST['quantita_giornaliera']; 
		$quantita_totale = $_POST['quantita_totale']; 
		$quantita_attuale = $_POST['quantita_attuale']; 
		$data_scadenza = $_POST['data_scadenza']; 
		
		$insert="INSERT INTO medicine (nome, prezzo, mutuabile, durata_giorni, quantita_giornaliera, quantita_tot, quantita_attuale, data_scadenza, data_nuovo) VALUES ('".$nome."', '".$prezzo."', '".$mutuabile."', '".$giorni_totali."', '".$quantita_giornaliera."', '".$quantita_totale."', '".$quantita_attuale."', '".$data_scadenza."', null);";
		$result = $db->query($insert);
		header("location: /pannello_controllo_new.php");
?>