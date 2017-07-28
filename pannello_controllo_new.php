<!DOCTYPE html>
<html>
  <head>
    <title>Lista Medicine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
 
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <ul class="nav nav-tabs">
	  <li class="active"><a href="#tab-1" data-toggle="tab">Lista</a></li>
	  <li><a href="#tab-2" data-toggle="tab">Aggiungi</a></li>
	</ul>
	  <div class="tab-content">
		<div class="tab-pane active" id="tab-1">

 <?php echo "<h2>Lista Medicine</h2><p>"; 
 
			
			 $db = new mysqli("localhost", "root", "onslario89", "test", 3306);
			
				if ($db->connect_errno) {
					echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				}
				echo "Connessione riuscita!";
				echo $db->host_info . "<p>";
				
				$sql = "SELECT * from medicine;";
				$result = $db->query($sql);
					
				if(!$result = $db->query($sql)){
    					die('There was an error running the query [' . $db->error . ']');
				}

				if ($result->num_rows > 0) {
					
					$today = date("Y-m-d");
					echo "Data odierna: ".$today."<p>";
					?>
					
				    <div class="table-responsive">
						<table class="table">
						  <thead>
							<tr>
							 
					<?php 
						
						echo "<th>Nome</th>";
						echo "<th>Prezzo(€)</th>";
						echo "<th>Mutuabile</th>";
						echo "<th>Durata(giorni)</th>";
						//echo "<th>Quantità giornaliera</th>";
						//echo "<th>Quantità totale</th>";
						echo "<th>Quantità attuale</th>";
						echo "<th>Data Scadenza</th>";
						//echo "<th>data_nuovo</th>";
						echo "</tr>";
						echo "</thead>";
					
					 while($row = $result->fetch_assoc()) {

						if($row["data_scadenza"]<$today){
									//echo "La prossima data di scadenza è: ".$row["data_scadenza"]."<p>";
						
									$quantitaGiornaliera=$row["quantita_giornaliera"];
									//echo "La quantità giornaliera è: ".$row["quantita_giornaliera"]."<p>";
									$durataGiorni=$row["durata_giorni"];
																		
									$giorni=(int)($durataGiorni * (1/$quantitaGiornaliera));
									//echo "La medicina sarà presa per giorni: ".$giorni."<p>";
									//es. se un medicina si prende 1 volt ogni 2 giorni: giorni=40*1/1/2=80
						
				
									 /*$query_aggiornamento1="SELECT data_scadenza FROM medicine WHERE nome='".$row["nome"]."';";
									$report1=$db->query($query_aggiornamento1);
									$dataNuova=$report1->fetch_assoc();*/
									

									$query_aggiornamento_scadenza="UPDATE medicine SET data_scadenza=(SELECT DATE_ADD('".$row['data_scadenza']."', INTERVAL '".$giorni."' DAY)) WHERE nome='".$row["nome"]."';";
									$report_aggiornamento=$db->query($query_aggiornamento_scadenza);
									//$dataNuova2=$report2->fetch_assoc();
							
						}
						///////////////aggiornamento data nuovo inizio medicine
						$query_aggiornamento_nuovo="UPDATE medicine SET data_nuovo=(SELECT DATE_ADD('".$row['data_scadenza']."', INTERVAL 1 DAY)) WHERE nome='".$row["nome"]."';";
						$report_inizio=$db->query($query_aggiornamento_nuovo);

						///////////////aggiornamento quantità attuale
						$newdate = strtotime("-".$row['quantita_tot']." day" , strtotime ($row["data_scadenza"])); //Calcola la data in cui è iniziata la medicina
						$newdate = date ( 'Y-m-d' , $newdate ); //trasformiamo la data nel formato accettato dal db YYYY-MM-DD
						//echo "La medicina è iniziata giorno: ".$newdate."<p>";
						$datetime1 = date_create($newdate);
						$datetime2 = date_create($today);
						$interval = date_diff($datetime2, $datetime1);
						//echo "La medicina è stata presa per giorni: ".$interval->format('%a')."<p>";
                     
						$differenza=$row["quantita_tot"]-$interval->format('%a');
						//echo "La quantità totale era: ".$row["quantita_tot"]."<p>";
						//echo "La quantità attuale è: ".$differenza."<p>";
						$query_aggiornamento3="UPDATE medicine SET quantita_attuale=".$differenza." WHERE nome='".$row["nome"]."';";
						$report3=$db->query($query_aggiornamento3);
						/////////////////////////////////////////////
										
						///////////////stampa riga
						
							echo "<tbody>"; 
							echo "<tr>"; 
							echo "<td>".$row['nome']."</td>"; 
							echo "<td>".$row['prezzo']."</td>";  
							echo "<td>".$row['mutuabile']."</td>";  
							echo "<td>".$row['durata_giorni']."</td>";  
							//echo "<td>".$row['quantita_giornaliera']."</td>";  
							//echo "<td>".$row['quantita_tot']."</td>";  
							echo "<td>".$row['quantita_attuale']."</td>"; 
									
								if($differenza < 5){
									echo "<td bgcolor='#FF0000'>".$row['data_scadenza']."</td>"; 
									}
								else{
									echo "<td>".$row['data_scadenza']."</td>";
									}
							//echo "<td>".$row['data_nuovo']."</td>"; 
							echo "</tr>"; 

					}//fine del while 
					
					echo "</table>";
				}
				
					
				else {
					echo "0 results"; 
			}
			//$db->close();
			?>
			
						</tbody>
					</table>
					
				</div>
				
			  <button style="position:relative; left:50%;" type="button" class="btn btn-primary" onclick="top.location.href = 'pannello_controllo_new.php'">Aggiorna</button>
			
		</div>	
		<div class="tab-pane" id="tab-2">
 			
				<div class="container container-table" style="width: 50%;">			
				
						
				<form method="POST" action="aggiungi.php" name="form">
				 <fieldset>
				  <div class="form-group">
				   <label for="nome">Nome medicina</label>
				   <input type="text" name="nome" class="form-control" id="nome" placeholder="Inserisci il nome...">
				  </div>
				  <div class="form-group">
				   <label for="cognome">Prezzo</label>
				   <input type="text" name="prezzo" class="form-control" id="cognome" placeholder="Inserisci il prezzo in euro...">
				  </div>
				  <div class="form-group">
				   <label for="stato">Mutuabile</label>
				   <select  name="mutuabile" class="form-control" id="stato">
					<option value="1">Si</option>
					<option value="0">No</option>
				   </select>
				  </div>
				  <div class="form-group">
				   <label for="cognome">Giorni totali</label>
				   <input type="text" name="giorni_totali" class="form-control" id="cognome" placeholder="Durata, in giorni, della confezione...">
				  </div>
				  <div class="form-group">
				   <label for="cognome">Quantità giornaliera</label>
				   <input type="text" name="quantita_giornaliera" class="form-control" id="cognome" placeholder="Quantità assunta in un giorno...">
				  </div>
				  <div class="form-group">
				   <label for="cognome">Quantità totale</label>
				   <input type="text" name="quantita_totale" class="form-control" id="cognome" placeholder="Unità della medicina nella confezione...">
				  </div>
				  <div class="form-group">
				   <label for="cognome">Quantità attuale</label>
				   <input type="text" name="quantita_attuale" class="form-control" id="cognome" placeholder="Quantità attuale della medicina nella confezione...">
				  </div>
				  <div class="form-group">
				   <label for="email">Data Scadenza</label>
				   <input type="text" name="data_scadenza" class="form-control" id="email" placeholder="Data scadenza in formato YYYY/MM/DD...">
				  </div>
				  
				   <button type="submit" class="btn btn-default">Invia</button>
				 </fieldset>
				</form>
				
			 </div>


			
			</div>
		
	  </div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
