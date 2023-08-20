<?php
$idMatiere = (int)preg_quote($_GET['id']);
$mat = $databases->getAllData('SELECT * FROM matiere m 
    JOIN filiere f ON m.idFiliere=f.idFiliere
    JOIN annee a ON a.idAnnee=m.idAnnee
    WHERE idMatiere='.$idMatiere);
ob_start();
include_once 'lienProf.php';
$filiere = $databases->requette('SELECT * FROM filiere');
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Modification Des Matières</div>
</div>
<div class="container">
	<div class="jumbotron">
		<form action="" method="POST">
			<?php
			$nMat = new Input('nmat','text','form-control',$mat['nomMatiere'],'Nom de la Matière');
			$nMat->CreatInput('Le Nom De La Matiere','Form-control');
			//=====================================================================
			$coef = new Input('coef','number','form-control',$mat['coeuf'],'');
			$coef->CreatInput('Le Cœfficien','form-group');
			//=====================================================================
			
			$bout = new Input('bout','submit','btn btn-info','Enregister','');
			$bout->CreatInput('','form-group');
			?>
		</form>
	</div>
</div>

<?php
$contentMatiere = ob_get_clean();
if(
	!empty($_POST[$nMat->getName()])
	AND !empty($_POST[$coef->getName()])
	AND !empty($_POST[$fil->getName()])
){
	$nomMat = strtolower($_POST[$nMat->getName()]).$_POST[$coef->getName()].$_POST[$fil->getName()];
	$dataMat = $databases->requette('SELECT * FROM matiere');
	while($dataMats = $dataMat->fetch()){
		$tabMat[] = strtolower($dataMats['nomMatiere']).$dataMats['idFiliere'].$dataMats['idAnnee'];
	}
	if(!in_array($nomMat,$tabMat)){
	$databases->ReqSecure('INSERT INTO matiere(nomMatiere,coeuf,idFiliere,idAnnee) VALUES (:nmat,:coeuf,:idFiliere,:annee)',[
		':nmat' => $_POST[$nMat->getName()],
		':coeuf' => $_POST[$coef->getName()],
		':idFiliere' => $_POST[$fil->getName()],
		':annee' => $_POST[$annee->getName()]  
	]);
			header('location: ../backend/Gpage.php?page=LprofMat&stat=1');
	}else{
			header('location: ../backend/Gpage.php?page=AjoutMatiere=2');
	}
}
echo $contentMatiere;
	