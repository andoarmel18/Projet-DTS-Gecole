<?php
$active = 2;
include_once 'lienProf.php';
$filiere = $databases->requette('SELECT * FROM filiere');
$sexe = [
	'Masculin' => 'Masculin',
	'Feminin' => 'Feminin'
];
$databases->requette('DELETE FROM conmdp');
$erreur = [];
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Ajout Des Profs</div>
</div>
<div class="container">
	<div class="jumbotron">
		<form action="" method="POST">
			<?php
			$nprof = new Input('nprof','text','form-control','','Nom');
			$nprof->CreatInput('Nom du Prof','Form-control');
			//=====================================================================
			$pprof = new Input('pp','text','form-control','','Prenom');
			$pprof->CreatInput('Prenom Du Prof','form-group');
			//=====================================================================
			$sprof = new Input('sprof','','form-control','');
			$sprof->creatSelectSimple('Sexe','form-group',$sexe,'Le sexe');
			//=====================================================================
			$numero = new Input('nump','text','form-control','','Numéro');
			$numero->CreatInput('Numero Du Prof','form-group');
			//=====================================================================
            $pmail = new Input('pmail','text','form-control','','azer@tyu.xyz');
			$pmail->CreatInput('Mail','form-group');
			if(!empty($_POST[$pmail->getName()]) AND filter_var($_POST[$pmail->getName()] , FILTER_VALIDATE_EMAIL) === false){
				echo '<div class="alert alert-danger">Mail Non Valide</div>';
				$erreur [] = true;
			}
            //=====================================================================
			$bout = new Input('bout','submit','btn btn-info','Enregister','');
			$bout->CreatInput('','form-group');
			?>
		</form>
	</div>
</div>

<?php
if(!in_array(true,$erreur)){
	
$dataProf = $databases->requette('SELECT * FROM prof');
while($dataProfs = $dataProf->fetch()){
	$tabProf[] = strtolower($dataProfs['nomProf'].$dataProfs['prenomProf']);
}
if(
	!empty($_POST[$nprof->getName()])
	AND !empty($_POST[$pprof->getName()])
	AND !empty($_POST[$numero->getName()])
    AND !empty($_POST[$pmail->getName()]))
	{
		$nom = strtolower($_POST[$nprof->getName()].$_POST[$pprof->getName()]);
		if(!in_array($nom,$tabProf)){
			$databases->ReqSecure('INSERT INTO prof(nomProf,prenomProf,sexe,numero,mail) VALUES (:nom,:prenom,:sexe,:numero,:mail)',[
				':nom' => $_POST[$nprof->getName()],
				':prenom' => $_POST[$pprof->getName()],
				':sexe' => $_POST[$sprof->getName()],
				':numero' => $_POST[$numero->getName()],
        		':mail' => $_POST[$pmail->getName()]
			]);
				header('location: ../backend/Gpage.php?page=Lprof&stat=1');
		}else{
			header('location: ../backend/Gpage.php?page=AjoutProf&stat=2');
		}
	}
}
	