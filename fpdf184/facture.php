<?php
require '../backend/class/bdd.php';
require '../fpdf184/fpdf.php';
$id = (int)preg_quote($_GET['id']);
$databases = new Database();
$user = $databases->getAllData('SELECT * FROM admin');
$info = $databases->getAllData('SELECT * FROM ecolage e 
    JOIN etudiant et ON e.matricule=et.matricule
    JOIN classe c ON c.idClasse=et.idClasse
    JOIN filiere f ON f.idFiliere=c.idFiliere
    JOIN mois m ON m.idMois = e.idMois
    WHERE idEcolage='.$id);
$andro = [
	'Mon' => 'Lundi',
	'Tue' => 'Mardi',
	'Wed' => 'Mercredi',
	'Thu' => 'Jeudi',
	'Fri' => 'Vendredi',
	'Sat' => 'Samedi',
	'Sun' => 'Dimanche'
];
$volana= [
	'Jan' => 'Janvier',
	'Feb' => 'Fevrier',
	'Mar' => 'Mars',
	'Apr' => 'Avril',
	'May' => 'Mai',
	'Jun' => 'Juin',
	'Jul' => 'Juillet',
	'Aug' => 'Aout',
	'Sep' => 'Septembre',
	'Oct' => 'Octobre',
	'Nov' => 'Novembre',
	'Dec' => 'Decembre'
];
$date = $andro[date('D')].' '.date('d').' '.$volana[date('M')].' '.date('Y');
$logo = '../photo/'.$user['photo'];
$nom = $user['nom'];
$nomEtud = $info['nom'];
$trait = '-------------------------------------------------------------';
//creation pdf
$pdf = new FPDF('L','mm',array(150,150));
$pdf->AddPage();
$pdf->Image($logo,60,0,30,30);
$pdf->SetFont('Arial','',14);
$pdf->Ln(20);
$pdf->Cell(0,0,$nom,0,0,'C');
$pdf->Ln(10);
$pdf->SetLeftMargin(100);
$pdf->Cell(40,7,$info['montant'],1,0,'L');
$pdf->Cell(40,7,'Ar',0,0);
$pdf->SetLeftMargin(0);
$pdf->Ln(15);
$pdf->SetFont('Arial','BU',12);
$pdf->Write(0,'Reçu de : ');
$pdf->SetLeftMargin(30);
$pdf->SetFont('Arial','',14);
$pdf->Write(0,$nomEtud);
$pdf->SetLeftMargin(10);
$pdf->Write(0,'  '.$info['prenom']);
$pdf->SetFont('Arial','',12);
$pdf->SetLeftMargin(0);
$pdf->Ln(0);
$pdf->SetFont('Arial','BU',12);
$pdf->Write(15,'Matricule :');
$pdf->SetLeftMargin(30);
$pdf->SetFont('Arial','',14);
$pdf->Write(15,$info['matricule']);
$pdf->SetLeftMargin(0);
$pdf->Ln(0);
$pdf->SetLeftMargin(80);
$pdf->SetFont('Arial','BU',12);
$pdf->Write(15,'Classe :');
$pdf->SetLeftMargin(30);
$pdf->SetFont('Arial','',14);
$pdf->Write(15,$info['nomClasse'].'('.$info['nomFiliere'].')');
$pdf->SetLeftMargin(0);
$pdf->Ln(0);
$pdf->SetFont('Arial','BU',12);
$pdf->Write(30,'Mois :');
$pdf->SetLeftMargin(30);
$pdf->SetFont('Arial','BU',12);
$pdf->SetFont('Arial','',14);
$pdf->Write(30,$info['mois']);
$pdf->Ln(0);
$pdf->SetLeftMargin(80);
$pdf->SetFont('Arial','BU',12);
$pdf->Write(30,'Payment De : ');
$pdf->SetFont('Arial','',14);
$pdf->Write(30,$info['typepay']);
$pdf->SetLeftMargin(70);
$pdf->Ln(30);
$pdf->Rect(7,80,130,50,);
$pdf->SetFont('Arial','',10);
$pdf->Write(0,'Fait le, ');
$pdf->Write(0,$date);
$pdf->SetLeftMargin(60);
$pdf->Ln(10);
$pdf->SetFont('Arial','B',14);
$pdf->Write(0,'Responsable');
$pdf->Output('','',true);
