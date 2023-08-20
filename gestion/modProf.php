<?php
$active = 2;
$idProfs=(int)preg_quote($_GET['id']);
ob_start();
include_once 'lienProf.php';
$profMod = $databases->getAllData('SELECT * FROM prof WHERE idProf='.$idProfs);
$sexe = [
	'Masculin' => 'Masculin',
	'Feminin' => 'Feminin'
];
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Modifications Des Profs</div>
</div>
<div class="container">
	<div class="jumbotron">
		<form action="" method="POST">
			<?php
			$nprof = new Input('nprof','text','form-control',$profMod['nomProf'],'Nom');
			$nprof->CreatInput('Nom du Prof','Form-control');
			//=====================================================================
			$pprof = new Input('pp','text','form-control',$profMod['prenomProf'],'Prenom');
			$pprof->CreatInput('Prenom Du Prof','form-group');
			//=====================================================================
			$sprof = new Input('sprof','','form-control','');
			$sprof->creatSelectSimple('Sexe','form-group',$sexe,$profMod['sexe']);
			//=====================================================================
			$numero = new Input('nump','text','form-control',$profMod['numero'],'Numéro');
			$numero->CreatInput('Numero Du Prof','form-group');
			//=====================================================================
            $pmail = new Input('pmail','text','form-control',$profMod['mail'],'azer@tyu.xyz');
			$pmail->CreatInput('Mail','form-group');
            //=====================================================================
			$bout = new Input('bout','submit','btn btn-info','Enregister','');
			$bout->CreatInput('','form-group');
			?>
		</form>
	</div>
</div>

<?php
$contenuprof = ob_get_clean();

if(
	!empty($_POST[$nprof->getName()])
	AND !empty($_POST[$pprof->getName()])
	AND !empty($_POST[$numero->getName()])
    AND !empty($_POST[$pmail->getName()]))
	{
		$nom = strtolower($_POST[$nprof->getName()].$_POST[$pprof->getName()]);
		
			$databases->ReqSecure('UPDATE prof SET nomProf=:nom, prenomProf=:prenom, sexe=:sexe, numero=:numero, mail=:mail WHERE idProf='.$idProfs,[
				':nom' => $_POST[$nprof->getName()],
				':prenom' => $_POST[$pprof->getName()],
				':sexe' => $_POST[$sprof->getName()],
				':numero' => $_POST[$numero->getName()],
        		':mail' => $_POST[$pmail->getName()]
			]);
				header('location: ../backend/Gpage.php?page=Lprof&stat=1');
		
	}
echo $contenuprof;
	