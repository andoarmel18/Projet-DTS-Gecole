<?php
ob_start();
$active = null;
include 'lienAccueil.php';
$resultat = preg_quote($_GET['id']);
$int = (int)($resultat);
$modif = $databases->getAllData('SELECT * FROM etudiant e 
    LEFT JOIN classe c ON e.idClasse=c.idClasse WHERE matricule = '.$int);

?>

<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">MODIFICATION</div>
</div>
<div style="margin-top: 0.5cm;"  class="container">
    <div class="jumbotron">
        <form action="#" method="post">
                <?php
                //===========================================================
                $matricule = new Input('matricule','number','form-control',$modif['matricule'],'Numéro matricule');
                $matricule->CreatInput('Le numéro matricule :' , 'form-group');
                //===========================================================
                $nom = new Input('nE','text','form-control',$modif['nom'],'Votre nom');
                $nom->CreatInput('Votre Nom :' , 'form-group');
                //===========================================================
                $prenom = new Input('pE','text','form-control',$modif['prenom'],'Votre Prenom');
                $prenom->CreatInput('Enter votre prenom :','form-group');
                //===========================================================
                $sexes = [
                    'masculin' => 'masculin',
                    'feminin' => 'feminin',
                    'autre' => 'autre'
                ];
                $sexe = new Input('sexe', '','form-control','','');
                $sexe->creatSelectSimple('Votre sexe :','from-group',$sexes,$modif['sexe']);
                //===========================================================
                $dateNaiss = new Input('dtn','date','form-control',$modif['dateNaiss'],'');
                $dateNaiss->CreatInput('Votre date de naissance :','form-group');
                //===========================================================
                $lnaiss = new Input('ln','text','form-control',$modif['lieuNaiss'],'votre lieu de naissance');
                $lnaiss->CreatInput('Votre lieu de naissance :','form-group');
                //===========================================================
                $num = new Input('num','text','form-control',$modif['numero'],'Numéro mobile');
                $num->CreatInput('Votre numéro mobile :','form-group');
                //===========================================================
                $mail = new Input('mail','mail','form-control',$modif['mail'],'ex: azer@abc.xyz');
                $mail->CreatInput('Votre adresse mail :','form-group');
                //===========================================================
                $adresse = new Input('adrs','text','form-control',$modif['adresse'],'adresse');
                $adresse->CreatInput('Votre adresse :','form-group');
                //===========================================================
                $pere = new Input('pr','text','form-control',$modif['pere'],'nom du pere');
                $pere->CreatInput('Père :','form-group');
                //===========================================================
                $mere = new Input('mr','text','form-control',$modif['mere'],'nom de la mere');
                $mere->CreatInput('mère :','form-group');
                //===========================================================
                $classes = $databases->requette('SELECT * FROM classe c JOIN filiere f ON c.idFiliere = f.idFiliere');
                $cl = new Input('classe','','form-control','','');
                $cl->CreatSelect('Choisir la classe :','form-group','idClasse','nomClasse','nomFiliere',$classes,$modif['nomClasse'],$modif['idClasse']);
                //===========================================================
                $bouton = new Input('bt' , 'submit','btn btn-success','Enregister','');
                $bouton->CreatInput('','form-group');
                ?>
        </form>
    </div>
</div>
<?php
$modifEtud = ob_get_clean();
if( !empty($_POST[$matricule->getName()]) AND 
    !empty($_POST[$nom->getName()]) AND 
    !empty($_POST[$prenom->getName()]) AND 
    !empty($_POST[$dateNaiss->getName()]) AND 
    !empty($_POST[$lnaiss->getName()]) AND 
    !empty($_POST[$mail->getName()]) AND 
    !empty($_POST[$adresse->getName()]) AND 
    !empty($_POST[$pere->getName()]) AND 
    !empty($_POST[$mere->getName()])){
       
             $databases->ReqSecure('UPDATE etudiant SET matricule = :mat, nom = :nom, prenom = :pren, sexe=:sexe ,dateNaiss = :dn, lieuNaiss = :ln, numero = :num, mail = :mail, adresse = :adresse, pere = :pere, mere = :mere, idClasse = :idC WHERE matricule = :idEtudiant',
            [':mat' => $_POST[$matricule->getName()],
             ':nom' => $_POST[$nom->getName()],
             ':pren' => $_POST[$prenom->getName()],
             ':sexe' => $_POST[$sexe->getName()],
             ':dn' => $_POST[$dateNaiss->getName()],
             ':ln' => $_POST[$lnaiss->getName()],
             ':num' => $_POST[$num->getName()],
             ':mail' => $_POST[$mail->getName()],
             ':adresse' => $_POST[$adresse->getName()],
             ':pere' => $_POST[$pere->getName()],
             ':mere' => $_POST[$mere->getName()],
             ':idC' => $_POST[$cl->getName()],
             'idEtudiant' => $_GET['id']
            ]);
        header('location: ../backend/Gpage.php?page=infoEtudiant&id='.$int);
        } 
echo $modifEtud;


    