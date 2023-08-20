<?php
$active = 1;
ob_start();
include_once 'lienProf.php';
$filiere = $databases->requette('SELECT * FROM filiere');
$tabMat= [];
$semestre = [
			1 => 'Premiere Semestre',
			2 => 'Deuxième Semestre'
			];
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Ajout Des Matières</div>
</div>
<div class="container">
	<div class="jumbotron">
		<form action="" method="POST">
			<?php
			$nMat = new Input('nmat','text','form-control','','Nom de la Matière');
			$nMat->CreatInput('Le Nom De La Matiere','Form-control');
			//=====================================================================
			$coef = new Input('coef','number','form-control','','');
			$coef->CreatInput('Le Cœfficien','form-group');
			//=====================================================================
			$sem = new Input('sem','','form-control','','');
			$sem->creatSelectSimple('Semestre :','form-group',$semestre,'');
			//=====================================================================
			$bout = new Input('bout','submit','btn btn-info','Enregister','');
			$bout->CreatInput('','form-group');
			?>
		</form>
	</div>
</div>

<?php
$contentMatiere = ob_get_clean();

if(isset($_GET['idfiliere']) AND isset($_GET['idAnnee'])){
	$idFiliere = (int)preg_quote($_GET['idfiliere']);
	$idAnnee = (int)preg_quote($_GET['idAnnee']);
	if(
		!empty($_POST[$nMat->getName()])
		AND !empty($_POST[$coef->getName()])
	){
		$nomMat = strtolower($_POST[$nMat->getName()]).$idFiliere.$idAnnee;
		$dataMat = $databases->requette('SELECT * FROM matiere');
		while($dataMats = $dataMat->fetch()){
			$tabMat[] = strtolower($dataMats['nomMatiere']).$dataMats['idFiliere'].$dataMats['idAnnee'];
		}
		if(!in_array($nomMat,$tabMat) OR count($dataMats) < 1){
		$databases->ReqSecure('INSERT INTO matiere(nomMatiere,coeuf,idFiliere,idAnnee,semestre) VALUES (:nmat,:coeuf,:idFiliere,:annee,:sem)',[
			':nmat' => $_POST[$nMat->getName()],
			':coeuf' => $_POST[$coef->getName()],
			':idFiliere' => $idFiliere,
			':annee' => $idAnnee,
			':sem' => $_POST[$sem->getName()]
		]);
				header('location: ../backend/Gpage.php?page=LprofMat&stat=1');
		}else{
				header('location: ../backend/Gpage.php?page=AjoutMatiere&stat=2');
		}
		
	}
	echo $contentMatiere;
		
}
