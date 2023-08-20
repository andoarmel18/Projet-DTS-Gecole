<?php
$active = null;
require_once 'lienAccueil.php';
$resultat = preg_quote($_GET['id']);
$int = (int)($resultat);
$infos = $databases->getAllData('SELECT * FROM etudiant e 
                        LEFT JOIN classe c ON e.idClasse=c.idClasse
                        LEFT JOIN filiere f ON c.idFiliere=f.idFiliere
                        WHERE matricule = '.$int);
$retard = $databases->requette('SELECT * FROM retard r 
    JOIN matiere m ON m.idMatiere=r.idMatiere
    WHERE matricule='.$int);
if(isset($_GET['source']) AND $_GET['source'] === 'archive'){
    $idClasse = (int)preg_quote($_GET['classe']);
    $infos = $databases->getAllData('SELECT * FROM arch_etud e 
                        LEFT JOIN arch_classe c ON e.idClasse=c.idClasse
                        LEFT JOIN filiere f ON c.idFiliere=f.idFiliere
                        WHERE matricule = '.$int.' AND e.idClasse='.$idClasse);
    $retard = $databases->requette('SELECT * FROM arch_retard r 
                        JOIN arch_etud ae ON ae.matricule=r.matricule
                        JOIN arch_classe ac ON ac.idClasse=ae.idClasse
                        JOIN matiere m ON m.idMatiere=r.idMatiere
                        WHERE r.matricule='.$int.' AND ae.idClasse='.$idClasse);
}
$year = $databases->requette('SELECT * FROM annee');

?>
<div class="container">
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">INFORMATION</div>
</div>
    <div class="jumbotron" style="display: flex;">
    
        <div class="col-md-5">
            <img style="width: 350px; height:350px"  class="img-fluid img-thumbnail" src="<?= '../photo/'.$infos['photo'] ?>">
            <br>
            <br>
           
            <button id="btn" class="btn btn-primary">Changer la photo</button>
            <br>
            <br>
            <div id="pict">
                <?php  if(isset($_GET['source']) AND $_GET['source'] == 'archive') :?>
               
                <?php else : ?>
                    <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="img" id="" class="from-control">
                    <input type="submit" value="Changer" class="btn btn-success">
                </form>
                <?php endif ?> 
            </div>
                <?php
                    if(!empty($_FILES['img']) AND $_FILES['img']['error'] == 0){
                        $file_info = pathinfo($_FILES['img']['name']);
                        $extension = $file_info['extension'];
                        $extension_autorised = ['jpeg' , 'png' ,'jpg'];
                        $name = basename($_FILES['img']['name']);
                    
                            if(in_array($extension , $extension_autorised)){
                                move_uploaded_file($_FILES['img']['tmp_name'],'../photo/'.$name);  
                                $stat = $databases->ReqSecure('UPDATE etudiant SET photo=:photo WHERE matricule='.$int,[
                                    ':photo' => $name
                                ]);
                                if($stat){
                                    header('location: ../backend/Gpage.php?page=infoEtudiant&id='.$int.'&stat=1');
                                }else{
                                    header('location: ../backend/Gpage.php?page=infoEtudiant&id='.$int.'&stat=5');
                                }
                            }
                    }

                ?>
            
            
        </div>
        <div class="col-md-5">
            <table class="table"> 
                <thead class="thead-light"> 
                   
                    <tr>
                        <th style="color:rgb(7, 202, 216);">Nom :<span  style="color: black;"><?="  ".$infos['nom']?></span></th>
                       
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Prenom : <span  style="color: black;"><?="  ".$infos['prenom']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Sexe : <span  style="color: black;"><?="  ".$infos['sexe']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Date de naissance :<span  style="color: black;"><?="  ".$infos['dateNaiss']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Lieu de Naissance :<span  style="color: black;"><?="  ".$infos['lieuNaiss']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Numero :<span  style="color: black;"><?="  ".$infos['numero']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Mail :<span  style="color: black;"><?="  ".$infos['mail']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Adresse :<span  style="color: black;"><?="  ".$infos['adresse']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Pere :<span  style="color: black;"><?="  ".$infos['pere']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Mere :<span  style="color: black;"><?="  ".$infos['mere']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Classe :<span  style="color: black;"><?="  ".$infos['nomClasse']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Filiere :<span  style="color: black;"><?="  ".$infos['nomFiliere']?></span></th>
                    </tr>
                </thead> 
                
            </table>
            
        
        </div>
    </div>
    <div class="d-flex justify-content-around">
        <button  id="ff" class="btn btn-info" >Payement FF</button>
        <button style="margin-left: 1cm;" id="nt" class="btn btn-warning">Les Notes</button>
        <button style="margin-left: 1cm;" id="brtd" class="btn btn-primary">Jour De Retard</button>
        <button style="margin-left: 1cm;" id="abs" class="btn btn-success">Jour D'absence</button>
    </div>
    <br>
    <div id="LFF" class="jumbotron">
        <div class="col-lg-6 offset-lg-3">
	        <div style="margin-top: 0.5cm;" class="section_title text-center">Fiche d'écolage</div>
        </div>
        <div>
            <table>
                <thead>
                    <tr><th class="table-primary">PAYER</th></tr>
                    <tr><th class="table-danger">NON PAYER</th></tr>  
                </thead>
            </table>
       
        </div>
        
        <?php while($years = $year->fetch()): $idAnnee = $years['idAnnee']?>
        <h4> <?=$years['annee']?></h4>
        <table border="2px" class="table" > 
            <thead class="thead-dark"> 

                <tr> 
                    <th>Janvier</th>
                    <th>Fevrier</th>
                    <th>Mars</th>
                    <th>Avril</th>
                    <th>Mai</th>
                    <th>Juin</th>
                    <th>Juillet</th>
                    <th>Aout</th>
                    <th>Septembre</th>
                    <th>Octobre</th>
                    <th>Novembre</th>
                    <th>Decembre</th>
                 </tr> 
            </thead> 
            <tbody> 
                <tr>
                <?php
                 $month = $databases->requette('SELECT * FROM mois'); 
                 while($months = $month->fetch()): ?> 
                <?php
                $idMonth = $months['idMois'];
                if(isset($_GET['source']) AND $_GET['source'] === 'archive'){
                    $monthPay = $databases->Chearch('SELECT * FROM arch_ecolage ec
                        LEFT JOIN arch_etud ae ON ec.matricule=ae.matricule
                        LEFT JOIN arch_classe ac ON ac.idClasse=ae.idClasse 
                        LEFT JOIN mois m ON m.idMois=ec.idMois 
                        WHERE ec.idAnnee='.$idAnnee.' AND ec.idMois='.$idMonth.' AND ec.matricule ='.$int.' AND ae.idClasse='.$idClasse);
                }else{
                    $monthPay = $databases->Chearch('SELECT * FROM ecolage ec LEFT JOIN mois m ON m.idMois=ec.idMois WHERE ec.idAnnee='.$idAnnee.' AND ec.idMois='.$idMonth.' AND matricule ='.$int);
                }
                ?> 
                <th <?php if($monthPay == true){echo 'class="table-primary"' ;}else{echo 'class="table-danger"';} ?> ></th> 
                <?php endwhile ?>   
                </tr> 
            </tbody> 
        </table>
        <br>
        <?php endwhile ?> 
        </div>

        <div id="rtd" class="card">
        <div class="col-lg-6 offset-lg-3">
	        <div class="section_title text-center">Les Jours De Retard</div>
        </div>
            <div class="table table-responsive">
                <table class="table table-bordered"> 
                    <thead class="thead-dark"> 
                        <tr> 
                            <th>Matiere</th> 
                            <th>Date</th> 
                            <th>Heure D'Enter</th> 
                            <th>Durée De Retard</th>
                            <th>Motif</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                        <?php while($retards = $retard->fetch()) : ?>
                        <tr> 
                            <th><?=$retards['nomMatiere']?></th> 
                            <th><?=$retards['date']?></th> 
                            <th><?=$retards['heureEntrer']?></th> 
                            <th><?=$retards['durer_retard']?></th>
                            <th><?=$retards['motif']?></th> 
                        </tr> 
                        <?php endwhile ?>
                    </tbody> 
            </table> 
        </div>
    </div>

    <div id="lnt" class="jumbotron" >
        <div class="col-lg-6 offset-lg-3">
	        <div class="section_title text-center">Les Notes</div>
        </div>
    <div style="display: flex;" >
        <div class="col-md-5">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <h3>1ere Semestre</h3>
                    <tr>
                        <th>Matiere</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $note = $databases->requette('SELECT * FROM note n
                    JOIN matiere m ON m.idMatiere=n.idMatiere
                    WHERE matricule='.$int.' AND n.semestre=1
                    ORDER BY m.nomMatiere');
                    if(isset($_GET['source']) AND $_GET['source'] === 'archive'){
                        $note = $databases->requette('SELECT * FROM arch_note n
                        JOIN matiere m ON m.idMatiere=n.idMatiere
                        WHERE matricule='.$int.' AND n.semestre=1 AND idClasse='.$idClasse.'
                        ORDER BY m.nomMatiere');
                    }
                    while($notes = $note->fetch()) :
                    ?>
                    <tr>
                        <th><?=$notes['nomMatiere']?></th>
                        <th><?=$notes['note']?></th>
                    </tr>
                    <?php endwhile?>
                </tbody>
            </table>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <table class="table table-bordered">
            <h3>2eme Semestre</h3>
                <thead class="thead-dark">
                    <tr>
                        <th>Matiere</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $note = $databases->requette('SELECT * FROM note n
                    JOIN matiere m ON m.idMatiere=n.idMatiere
                    WHERE matricule='.$int.' AND n.semestre=2
                    ORDER BY m.nomMatiere');
                    if(isset($_GET['source']) AND $_GET['source'] === 'archive'){
                        $note = $databases->requette('SELECT * FROM arch_note n
                        JOIN matiere m ON m.idMatiere=n.idMatiere
                        WHERE matricule='.$int.' AND n.semestre=1 AND idClasse='.$idClasse.'
                        ORDER BY m.nomMatiere');
                    }
                    while($notes = $note->fetch()) :
                    ?>
                    <tr>
                        <th><?=$notes['nomMatiere']?></th>
                        <th><?=$notes['note']?></th>
                    </tr>
                    <?php endwhile?>
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <div id="labs" class="jumbotron">
    <div class="col-lg-6 offset-lg-3">
	        <div class="section_title text-center">Les Jours d'Absences</div>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Matiere</th>
                    <th>Date</th>
                    <th>Motif</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $absent = $databases->requette('SELECT * FROM absence ab
                JOIN matiere m ON ab.idMatiere=m.idMatiere
                WHERE matricule='.$int);
                if(isset($_GET['source']) AND $_GET['source'] === 'archive'){
                    $absent = $databases->requette('SELECT * FROM arch_absence ab
                    JOIN arch_etud ae ON ab.matricule=ae.matricule
                    JOIN arch_classe ac ON ac.idClasse=ae.idClasse
                    JOIN matiere m ON ab.idMatiere=m.idMatiere
                    WHERE ab.matricule='.$int.' AND ae.idClasse='.$idClasse);
                }
                while($absents = $absent->fetch()) :
                ?>
                <tr>
                    <th><?=$absents['nomMatiere']?></th>
                    <th><?=$absents['dateAbs']?></th>
                    <th><?=$absents['motif']?></th>
                </tr>
                <?php endwhile?>
            </tbody>
        </table>
    </div>  <br>
   


</div>

