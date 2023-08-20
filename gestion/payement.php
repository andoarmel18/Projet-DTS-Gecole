<?php
ob_start();
$active = 'pmt';
include 'lienPayement.php';
$eleve = $databases->requette('SELECT * FROM etudiant ORDER BY matricule');
$month = $databases->requette('SELECT * FROM mois');
$eleves = new Input('np','','form-control','','');
$montant = new Input('montant','number','form-control','','Montant en ARIARY');
$mois = new Input('mois','','form-control','','');
$type = new Input('type','','form-control','','');
$bouton = new Input('bt' , 'submit','btn btn-success','Payer','');
$findPayement = [];
$mdp = $databases->getAllData('SELECT mdp FROM admin');
$idMdp = (int)preg_quote($_GET['idmdp']);
$userMdp = $databases->getAllData('SELECT mdpconfirm FROM conmdp WHERE id='.$idMdp);
$typePay = [
	'FF' => 'FF',
	'Droit D\'Enter' => 'Droit D\'Enter',
	'Droit d\'Examen' => 'Droit d\'Examen',
	'Autre' => 'Autre'
];
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Payement</div>
</div>
<div class="container">
	<div class="jumbotron">
		<form action="#" method="post">
		<?php
		$eleves->CreatSelect('Selectionner Le nom','from-group','matricule','matricule','prenom',$eleve,'Le nom de l\'etudiant','');
		$montant->CreatInput('Enter le montant','form-group');
		$mois->CreatSelect('Selectionner le mois','form-group','idMois','mois','',$month,'','');
		$type->creatSelectSimple('Payment De:','form-group',$typePay,'');
		$bouton->CreatInput('','form-group');
		?>
		</form>
	</div>
</div>
<?php
$payement = ob_get_clean();

if(!empty($_POST[$eleves->getName()])
AND !empty($_POST[$montant->getName()])){

	$matricule = $databases->getAllData('SELECT * FROM etudiant et 
		JOIN classe c ON et.idClasse=c.idClasse
		JOIN annee a ON a.idAnnee=c.idAnnee
		WHERE et.matricule='.$_POST[$eleves->getName()]);

	$ecolage = $databases->requette('SELECT * FROM ecolage e
	JOIN mois m ON e.idMois=m.idMois
	JOIN annee a ON a.idAnnee=e.idAnnee
	JOIN etudiant et ON et.matricule=e.matricule');
	while($ecolages = $ecolage->fetch()){
		$findPayement [] = $ecolages['matricule'].$ecolages['idMois'].$ecolages['idAnnee'];
	}
	$inPayment = $_POST[$eleves->getName()].$_POST[$mois->getName()].$matricule['idAnnee'];
	if(!in_array($inPayment,$findPayement) OR (int)compter('ecolage') == 0 ){
		
		$databases->ReqSecure('INSERT INTO ecolage(montant, dateP, idMois, idAnnee, matricule, typepay)
			VALUES (:montant, :dateP , :mois, :annee, :matricule, :type)',
				[
				':montant' => $_POST[$montant->getName()],
				':dateP' => date('d-F-Y'),
				':mois' =>  $_POST[$mois->getName()],
				':annee'  =>$matricule['idAnnee'],
				':matricule' => $_POST[$eleves->getName()],
				':type' => $_POST[$type->getName()]
				]);
		header('location: ../backend/Gpage.php?page=listePayement&stat=1');
	}else{
		$volana = $databases->getAllData('SELECT * FROM mois
		WHERE idMois='.$_POST[$mois->getName()]);
		echo 
            '<script>
                alert("Le matricule '.$_POST[$eleves->getName()].' a déjat payer le mois du '.$volana['mois'].'")
            </script>';
	}
}
if($mdp['mdp'] === $userMdp['mdpconfirm']){
	echo $payement;
}else{
	header('location: ../backend/Gpage.php?page=confMdp&stat=4');
}

	
