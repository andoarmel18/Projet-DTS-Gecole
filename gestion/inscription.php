<?php 
$active = 'ins';
require_once 'lienAccueil.php';
$mat = [];
$databases->requette('DELETE FROM conmdp');
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">INSCRIPTION</div>
</div>
<div style="margin-top: 0.5cm;"  class="container">
    <div class="jumbotron">
        <form action="#" method="post" enctype="multipart/form-data">
                <?php
                $erreur = [];
                //===========================================================
                $photo = new Input('sary','file','form-control','','');
                $photo->CreatInput('Enter votre photo :','form-group');
                //===========================================================
                $matricule = new Input('matricule','number','form-control','','Numéro matricule');
                $matricule->CreatInput('Le numéro matricule :' , 'form-group');
                //===========================================================
                $nom = new Input('nE','text','form-control','','Votre nom');
                $nom->CreatInput('Votre Nom :' , 'form-group');
                //===========================================================
                $prenom = new Input('pE','text','form-control','','Votre Prenom');
                $prenom->CreatInput('Enter votre prenom :','form-group');
                //===========================================================
                $sexes = [
                    'masculin' => 'masculin',
                    'feminin' => 'feminin',
                    'autre' => 'autre'
                ];
                $sexe = new Input('sexe', '','form-control','','');
                $sexe->creatSelectSimple('Votre sexe :','form-group',$sexes);
                //===========================================================
                $dateNaiss = new Input('dtn','date','form-control','','');
                $dateNaiss->CreatInput('Votre date de naissance :','form-group');
                //===========================================================
                $lnaiss = new Input('ln','text','form-control','','votre lieu de naissance');
                $lnaiss->CreatInput('Votre lieu de naissance :','form-group');
                //===========================================================
                $num = new Input('num','text','form-control','','Numéro mobile');
                $num->CreatInput('Votre numéro mobile :','form-group');
                //===========================================================
                $mail = new Input('mail','mail','form-control','','ex: azer@abc.xyz');
                $mail->CreatInput('Votre adresse mail :','form-group');
                if(!empty($_POST[$mail->getName()]) AND filter_var($_POST[$mail->getName()] , FILTER_VALIDATE_EMAIL) === false){
                    echo '<div class="alert alert-danger">Mail Non Valide</div>';
                    $erreur [] = true;
                }
                //===========================================================
                $adresse = new Input('adrs','text','form-control','','adresse');
                $adresse->CreatInput('Votre adresse :','form-group');
                //===========================================================
                $pere = new Input('pr','text','form-control','','nom du pere');
                $pere->CreatInput('Père :','form-group');
                //===========================================================
                $mere = new Input('mr','text','form-control','','nom de la mere');
                $mere->CreatInput('mère :','form-group');
                //===========================================================
                $classes = $databases->requette('SELECT * FROM classe c JOIN filiere f ON c.idFiliere=f.idFiliere ORDER BY nomClasse,nomFiliere');
                $cl = new Input('classe','','form-control','','');
                $cl->CreatSelect('Choisir la classe :','form-group','idClasse','nomClasse','nomFiliere',$classes,'',0);
                //===========================================================
                
                
                $bouton = new Input('bt' , 'submit','btn btn-success','Enregister','');
                $bouton->CreatInput('','form-group');
                ?>
        </form>
    </div>
</div>

<?php
if(!in_array(true,$erreur)){
   
$etudiant = $databases->requette('SELECT e.matricule FROM etudiant e  ORDER BY matricule');
while($etudiants = $etudiant->fetch()){
    $mat[] = $etudiants['matricule'];
}



$sary = $photo->getName();
if(!empty($_FILES[$sary]) AND $_FILES[$sary]['error'] == 0){
    $file_info = pathinfo($_FILES[$sary]['name']);
    $extension = $file_info['extension'];
    $extension_autorised = ['jpeg' , 'png' ,'jpg'];
    $name = basename($_FILES[$sary]['name']);

        if(in_array($extension , $extension_autorised)){
            move_uploaded_file($_FILES[$sary]['tmp_name'],'../photo/'.$name);

            if( !empty($_POST[$matricule->getName()]) AND 
                !empty($_POST[$nom->getName()]) AND 
                !empty($_POST[$prenom->getName()]) AND 
                !empty($_POST[$dateNaiss->getName()]) AND 
                !empty($_POST[$lnaiss->getName()]) AND 
                !empty($_POST[$mail->getName()]) AND 
                !empty($_POST[$adresse->getName()]) AND 
                !empty($_POST[$pere->getName()]) AND 
                !empty($_POST[$mere->getName()])){

                    if(!in_array($_POST[$matricule->getName()],$mat) OR (int)count($mat)== 0){

                        $databases->ReqSecure('INSERT INTO etudiant (photo,matricule,nom,prenom,sexe,dateNaiss,lieuNaiss,numero,mail,adresse,pere,mere,idClasse) 
                        VALUES (:picture , :mat , :nom , :pren , :sexe , :dn , :ln , :num , :mail , :adresse , :pere , :mere , :idC )',
                        [':picture' => $name,
                         ':mat' => $_POST[$matricule->getName()],
                         ':nom' => $_POST[$nom->getName()],
                         ':pren' => $_POST[$prenom->getName()],
                         ':sexe'  => $_POST[$sexe->getName()],
                         ':dn' => $_POST[$dateNaiss->getName()],
                         ':ln' => $_POST[$lnaiss->getName()],
                         ':num' => $_POST[$num->getName()],
                         ':mail' => $_POST[$mail->getName()],
                         ':adresse' => $_POST[$adresse->getName()],
                         ':pere' => $_POST[$pere->getName()],
                         ':mere' => $_POST[$mere->getName()],
                         ':idC' => $_POST[$cl->getName()]
                        ]);
                    
                        header('location: ../backend/Gpage.php?page=listeEtud&stat=1');
                    }else{
                        header('location: ../backend/Gpage.php?page=inscription&stat=2');  
                    }        
            }else{
           echo 
           '<script>
                alert("Echec d\'Enregistrement");
            </script>';
            }
        }
    }
}



  





