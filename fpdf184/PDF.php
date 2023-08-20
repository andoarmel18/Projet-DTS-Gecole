<?php
$idClasse = (int)preg_quote($_GET['id']);
$sem = (int)preg_quote($_GET['semestre']);
if($sem == 1){
    $semstre = 'PREMIERE SEMESTRE';
}
if($sem == 2){
    $semstre = 'DEUXIEME SEMESTRE';
}
require '../backend/class/bdd.php';
$databases = new Database();
require '../fpdf184/fpdf.php';

$nomClasse = $databases->getAllData('SELECT * FROM classe c 
    JOIN filiere f ON c.idFiliere=f.idFiliere
    WHERE idClasse='.$idClasse);
$idFiliere = $nomClasse['idFiliere'];
$idAnnee = $nomClasse['idAnnee'];
$classe = $nomClasse['nomClasse'].'('.$nomClasse['nomFiliere'].').pdf';
$classes = $nomClasse['nomClasse'].' ('.$nomClasse['nomFiliere'].')';
$i=1;
$etudiant = $databases->requette('SELECT * FROM etudiant WHERE idClasse='.$idClasse);
$pdf = new FPDF('P','mm','A4');
while($etudiants = $etudiant->fetch()){
$pdf->AddPage();
$user = $databases->getAllData('SELECT * FROM admin');
$image = '../photo/'.$user['photo'];
$nom = $user['nom'];
$adresse = $user['adresse'];
$slogan = '"'.$user['slogan'].'"';
$nomEtud = strtoupper($etudiants['nom']).' '.ucfirst($etudiants['prenom']);
$matricule =  $etudiants['matricule'];
$anne_scol = $nomClasse['annee_scolaire'];
$pdf->SetFont('Arial','',14);
//image logo
$pdf->Image($image,90,2,30,30);
//retour a la lingr
$pdf->Ln(30);
//texte
$pdf->SetFont('','B');
$pdf->Cell(190,0,$nom,'','','C');
$pdf->Ln(9);
$pdf->Text(75,50,$adresse);
$pdf->Ln(9);
$pdf->SetFont('','BI');
$pdf->Cell(190,0,$slogan,'','','C');
$pdf->Ln(9);
$pdf->SetFont('','B');
$pdf->Cell(190,0,$semstre,'','','C');
$pdf->Ln(9);
$pdf->Cell(190,0,$anne_scol,'','','C');
$pdf->Ln(9);
$pdf->SetFont('','U');
$pdf->Write(0,'NOM ET PRENOM :','');
$pdf->SetFont('','B');
$pdf->Write(0," ".$nomEtud."\n");
$pdf->SetFont('','U');
$pdf->Write(15,"MATRICULE : ");
$pdf->SetFont('','B');
$pdf->Write(15," ".$matricule."\n");
$pdf->SetFont('','U');
$pdf->Write(0,"CLASSE : ");
$pdf->SetFont('','B');
$pdf->Write(0," ".$classes."\n");
$pdf->Ln(10 );
$pdf->Cell(60,10,'Matiere','LTBR');
$pdf->Cell(40,10,'Notes/20','TBR');
$pdf->Cell(40,10,'Coef','TBR');
$pdf->Cell(40,10,'Note/Coef','LTBR');
$pdf->Ln();
$matiere = $databases->requette('SELECT * FROM matiere 
    WHERE idFiliere='.$idFiliere.' AND idAnnee='.$idAnnee.' AND semestre='.$sem);
while($matieres = $matiere->fetch()) {
    $idMatiere = $matieres['idMatiere'];
    $note = $databases->requette('SELECT * FROM note WHERE idClasse='.$idClasse.' AND matricule='.$matricule.' AND idMatiere='.$idMatiere.' AND semestre='.$sem);
    while($notes = $note->fetch()){
        $strNote = str_replace(',','.',$notes['note']);
        $floatNote = floatval($strNote);
        $coefNote = $floatNote*(int)$matieres['coeuf'];
        $pdf->Cell(60,10,$matieres['nomMatiere'],'LTBR');
        $pdf->Cell(40,10,$notes['note'],'TBR');
        $pdf->Cell(40,10,$matieres['coeuf'],'TBR');
        $pdf->Cell(40,10,$coefNote,'LTBR');
        $pdf->Ln();
        $noteTotal [] = $coefNote;
        $totalCoef [] = (int)$matieres['coeuf'];
    }
    
}
$noteTotals = array_sum($noteTotal);
$totalCoefs = array_sum($totalCoef);
$moyenne = $noteTotals/$totalCoefs;
$pdf->Ln(7);
//Total
$pdf->Cell(60,10,'TOTAL','LTBR');
$pdf->Cell(60,10,$noteTotals,'LTBR');
$pdf->Ln();
//Moyenne
$pdf->Cell(60,10,'MOYENNE','LTBR');
$pdf->Cell(60,10,$moyenne,'LTBR');
$pdf->Ln(15);
//Observation
$pdf->Cell(180,10,'OBSERVATION','LTBR',-2,'C');
$pdf->Ln();
$pdf->Cell(180,30,'','LTBR');
$noteTotal = [];
$totalCoef = [];
}
$pdf->Output('I',$classe,true);
?>