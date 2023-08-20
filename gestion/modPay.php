<?php
$erreur = null;
$content = null;
$idPayment = (int)preg_quote($_GET['id']);
$eleve = $databases->requette('SELECT * FROM etudiant ORDER BY matricule');
$month = $databases->requette('SELECT * FROM mois');
$years = $databases->requette('SELECT * FROM annee');
$dataPayement = $databases->getAllData('SELECT * FROM ecolage ec 
    JOIN etudiant et ON ec.matricule=et.matricule
    JOIN mois m ON ec.idMois=m.idMois
    JOIN annee a ON ec.idAnnee=a.idAnnee WHERE idEcolage='.$idPayment);
$payemnt = new Input('np','','form-control','','');
$montant = new Input('montant','number','form-control',$dataPayement['montant'],'Montant en ARIARY');
$mois = new Input('mois','','form-control','','');
$annee = new Input('annee','','form-control','','');
$pay = new Input('pay','','form-control','','');
$bouton = new Input('bt' ,'submit','btn btn-success','Payer','');
include_once 'lienPayement.php';
$typePay = [
	'FF' => 'FF',
	'Droit D\'Enter' => 'Droit D\'Enter',
	'Droit d\'Examen' => 'Droit d\'Examen',
	'Autre' => 'Autre'
];
?>

<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Modification Du Payement</div>
</div>
<div class="container">
	<div class="jumbotron">
		<form action="#" method="post">
		<?php
        $nom = $dataPayement['nom'].' '.$dataPayement['prenom'];
		$payemnt->CreatSelect('Selectionner Le nom','from-group','matricule','matricule','prenom',$eleve,$nom,$dataPayement['matricule']);
		$montant->CreatInput('Enter le montant','form-group');
		$mois->CreatSelect('Selectionner le mois','form-group','idMois','mois','',$month,$dataPayement['mois'],$dataPayement['idMois']);
		$annee->CreatSelect('Selectionner l\'année','form-group','idAnnee','annee','',$years,$dataPayement['annee'],$dataPayement['idAnnee']);
		$pay->creatSelectSimple('Payment De:','form-group',$typePay,$dataPayement['typepay']);
		$bouton->CreatInput('','form-group');
		?>
		</form>
	</div>
</div>
<?php

if(!empty($_POST[$payemnt->getName()])
    AND !empty($_POST[$montant->getName()])
    AND !empty($_POST[$annee->getName()])){

        $mpdPay = $databases->ReqSecure('UPDATE ecolage set typepay= :typeP, montant= :montant, dateP= :dateP, idMois= :idMois ,idAnnee= :idAnnee, matricule= :matricule WHERE idEcolage='.$idPayment,
        [
			':typeP' => $_POST[$pay->getName()],
            ':montant' => $_POST[$montant->getName()],
			':dateP' => date('d-F-Y'),
			':idMois' =>  $_POST[$mois->getName()],
			':idAnnee'  => $_POST[$annee->getName()],
			':matricule' => $_POST[$payemnt->getName()]
        ]);
        header('location: ../backend/Gpage.php?page=listePayement&stat=1');
}

?>


