<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 2cm;" class="section_title text-center">Resultat de Recherche</div>
</div>
<?php 
$valClass = false;
$valProf = false;
$verEtds = false;
$archive = false;
$archEtds = false;

if(isset($_POST['chercher'])){
    $Pinput = $_POST['chercher'];
    $input = "'%".$_POST['chercher']."%'";
    $nomEtd = findMot($_POST['chercher'],'etudiant','nom');
    $prenomEtd = findMot($_POST['chercher'],'etudiant','prenom');
    $matricule = findMot($_POST['chercher'],'etudiant','matricule');
    $nomProf = findMot($_POST['chercher'],'prof','nomProf');
    $prenomProf = findMot($_POST['chercher'],'prof','prenomProf');
    $classe = findMot($_POST['chercher'],'classe','nomClasse');
    $inArchClasse = findMot($_POST['chercher'],'arch_classe','nomClasse');
    $inArchEtudNom = findMot($_POST['chercher'],'arch_etud','nom');
    $inArchEtudPreNom = findMot($_POST['chercher'],'arch_etud','prenom');
    $archmatricule = findMot($_POST['chercher'],'arch_etud','matricule');
}
if(isset($_GET['lien'])){
    $Pinput = $_GET['lien'];
    $input =preg_quote("'%".$_GET['lien']."%'");
}
?>
 
<?php if(isset($Pinput)) : ?>

    <?php if(preg_match("/[a-z0-9]/i",$Pinput)) : ob_start();?>

                <div class="container">
                    <div class="card">
                        <div class="justify-content-center border-bottom section_title text-center">
                            <strong style="color:black;font-size:35px;font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">Etudiant</strong>
                            
                                
                                <?php
                                $verEtds = $databases->Chearch('SELECT matricule,nom,prenom
                                FROM etudiant 
                                WHERE matricule LIKE '.$input.'
                                OR nom LIKE '.$input.' 
                                OR prenom LIKE '.$input);
                                if($verEtds) :
                                    $etudiant = $databases->requette('SELECT matricule,nom,prenom
                                    FROM etudiant 
                                    WHERE matricule LIKE '.$input.'
                                    OR nom LIKE '.$input.' 
                                    OR prenom LIKE '.$input);
                                ?>
                                    <div class="alert alert-info">
                                        <ul style="font-size: 20px;" class="section_title text-center">
                                            <?php while($etudiants = $etudiant->fetch()) : ?>
                                                <a href="../backend/Gpage.php?page=infoEtudiant&id=<?=$etudiants['matricule']?>" >
                                                    <li><span class="fa fa-users"><?=$etudiants['matricule'].' '.$etudiants['nom'].' '.$etudiants['prenom']?></span></li>
                                                </a>
                                            <?php endwhile ?>
                                        </ul>
                                    </div>  
                                    <?php else : ?>
                                        <div class="alert alert-danger">
                                            <p>Aucun Resultat</p>
                                        </div> 
                                <?php endif  ?>  
                            
                            
                        </div>

                        <div class="justify-content-center border-bottom section_title text-center">
                            <strong style="color:black;font-size:35px;font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">Prof</strong>
                                <?php
                                
                                $valProf = $databases->Chearch('SELECT idProf,nomProf,prenomProf
                                FROM prof 
                                WHERE nomProf LIKE '.$input.'
                                OR prenomProf LIKE '.$input);
                                if($valProf) :
                                    $prof = $databases->requette('SELECT idProf,nomProf,prenomProf
                                    FROM prof 
                                    WHERE nomProf LIKE '.$input.'
                                    OR prenomProf LIKE '.$input);
                                ?>
                                <div class="alert alert-info">
                                    <ul style="font-size: 20px;" class="section_title text-center">
                                    <?php while($profs = $prof->fetch()) : ?>
                                        <a href="../backend/Gpage.php?page=Lprof" >
                                            <li><span class="fa fa-graduation-cap"><?=$profs['nomProf'].' '.$profs['prenomProf']?></span></li>
                                        </a>
                                    <?php endwhile ?>
                                    </ul>
                                </div>
                            <?php else :  ?> 
                                <div class="alert alert-danger">
                                    <p>Aucun Resultat</p>
                                </div>
                            <?php endif  ?>  
                        </div>

                        <div class="justify-content-center border-bottom section_title text-center">
                            <strong style="color:black;font-size:35px;font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">Classe</strong>
                           
                                <?php
                                
                                $valClass = $databases->Chearch('SELECT DISTINCT c.idClasse,c.nomClasse,f.nomFiliere,f.idFIliere
                                FROM classe c JOIN filiere f ON c.idFiliere=c.idFiliere
                                WHERE nomClasse LIKE '.$input.' GROUP BY f.nomFiliere');
                                if($valClass) : 
                                    $dataclasse = $databases->requette('SELECT DISTINCT c.idClasse,c.nomClasse,f.nomFiliere,f.idFIliere
                                    FROM classe c JOIN filiere f ON c.idFiliere=c.idFiliere
                                    WHERE nomClasse LIKE '.$input.' GROUP BY f.nomFiliere');
                                ?>
                                <div class="alert alert-info">
                                    <ul style="font-size: 20px;" class="section_title text-center">
                                        <?php while($dataclasses = $dataclasse->fetch()) : ?>
                                            <a href="../backend/Gpage.php?page=infoClasse&id=<?=$dataclasses['idClasse']?>">
                                                <li><span class="fa "><?=$dataclasses['nomClasse'].'('.$dataclasses['nomFiliere'].')'?></span></li>
                                            </a>
                                        <?php endwhile ?>
                                    </ul>
                                </div>
                                <?php else :  ?> 
                                    <div class="alert alert-danger">
                                        <p>Aucun Resultat</p>
                                    </div>
                                <?php endif ?>  
                        </div>
<br>
                        <div class="justify-content-center border-bottom section_title text-center">
                            <strong style="color:black;font-size:35px;font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">Archive</strong><br>
                                <i>Classe</i>
                                <?php
                                $archive = $databases->Chearch('SELECT DISTINCT c.idClasse,c.nomClasse,f.nomFiliere,f.idFIliere
                                FROM arch_classe c JOIN filiere f ON c.idFiliere=c.idFiliere
                                WHERE nomClasse LIKE '.$input.' GROUP BY f.nomFiliere');
                                if($archive) : 
                                    $dataclasse = $databases->requette('SELECT DISTINCT c.idClasse,c.nomClasse,f.nomFiliere,f.idFIliere
                                    FROM arch_classe c JOIN filiere f ON c.idFiliere=c.idFiliere
                                    WHERE nomClasse LIKE '.$input.' GROUP BY idClasse');
                                ?>
                                <div class="alert alert-info">
                                    <ul style="font-size: 20px;" class="section_title text-center">
                                        <?php while($dataclasses = $dataclasse->fetch()) : ?>
                                            <a href="../backend/Gpage.php?page=listeArchive&id=<?=$dataclasses['idClasse']?>&source=archive">
                                                <li><span class="fa "><?=$dataclasses['nomClasse'].'('.$dataclasses['nomFiliere'].')'?></span></li>
                                            </a>
                                        <?php endwhile ?>
                                    </ul>
                                </div>
                                <?php else :  ?> 
                                    <div class="alert alert-danger">
                                        <p>Aucun Resultat</p>
                                    </div>
                                <?php endif ?> 
                                <i>Etudiant</i>
                                <?php
                                $archEtds = $databases->Chearch('SELECT *
                                FROM arch_etud ae
                                JOIN arch_classe ac ON ae.idClasse=ac.idClasse
                                JOIN filiere f ON f.idFiliere=ac.idFiliere
                                WHERE matricule LIKE '.$input.'
                                OR nom LIKE '.$input.' 
                                OR prenom LIKE '.$input.'
                                GROUP BY ae.idClasse');
                                if($archEtds) :
                                    $etudiant = $databases->requette('SELECT *
                                    FROM arch_etud ae
                                    JOIN arch_classe ac ON ae.idClasse=ac.idClasse
                                    JOIN filiere f ON f.idFiliere=ac.idFiliere
                                    WHERE matricule LIKE '.$input.'
                                    OR nom LIKE '.$input.' 
                                    OR prenom LIKE '.$input.'
                                    GROUP BY ae.idClasse');
                                ?>
                                    <div class="alert alert-info">
                                        <ul style="font-size: 20px;" class="section_title text-center">
                                            <?php while($etudiants = $etudiant->fetch()) : ?>
                                                <a href="../backend/Gpage.php?page=infoEtudiant&id=<?=$etudiants['matricule']?>&source=archive&classe=<?=$etudiants['idClasse']?>" >
                                                    <li><span class="fa fa-users"><?=$etudiants['matricule'].' '.$etudiants['nom'].' '.$etudiants['prenom']?></span></li>
                                                </a>
                                            <?php endwhile ?>
                                        </ul>
                                    </div>  
                                    <?php else : ?>
                                        <div class="alert alert-danger">
                                            <p>Aucun Resultat</p>
                                        </div> 
                                <?php endif  ?>  
                        </div>
                    </div>
                </div>
               <br> 
            
    <?php endif ?>    

<?php endif; $content = ob_get_clean() ?>
<div class="container">
<?php
if($valClass === false AND $valProf=== false AND $verEtds === false){
    if(isset($nomEtd)){
        echo 'essayer avec :<br>';
        foreach($nomEtd as $lien){
            echo 
            '<a href="../backend/Gpage.php?page=find&lien='.$lien.'">'.$lien.'</a><br>';
        }
       
    }
    if(isset($prenomEtd)){
        echo 'essayer avec :<br>';
        foreach($prenomEtd as $lien){
            echo 
            '<a href="../backend/Gpage.php?page=find&lien='.$lien.'">'.$lien.'</a><br>';
        }
    }
    if(isset($matricule)){
        echo 'essayer avec :<br>';
        foreach($matricule as $lien){
            echo 
            '<a href="../backend/Gpage.php?page=find&lien='.$lien.'">'.$lien.'</a><br>';
        }
    }
    if(isset($nomProf)){
        echo 'essayer avec :<br>';
        foreach($nomProf as $lien){
            echo 
            '<a href="../backend/Gpage.php?page=find&lien='.$lien.'">'.$lien.'</a><br>';
        }
    }
    if(isset($prenomProf)){
        echo 'essayer avec :<br>';
        foreach($prenomProf as $lien){
            echo 
            '<a href="../backend/Gpage.php?page=find&lien='.$lien.'">'.$lien.'</a><br>';
        }
    }
    if(isset($classe)){
       echo 'essayer avec :<br>';
            foreach($classe as $lien){
                echo 
                '<a href="../backend/Gpage.php?page=find&lien='.$lien.'">'.$lien.'</a><br>';
            }       
    }
    if(isset($inArchClasse)){
        echo 'essayer avec :<br>';
             foreach($inArchClasse as $lien){
                 echo 
                 '<a href="../backend/Gpage.php?page=find&lien='.$lien.'">'.$lien.'</a><br>';
             }       
     }
     if(isset($inArchEtudNom)){
        echo 'essayer avec :<br>';
             foreach($inArchEtudNom as $lien){
                 echo 
                 '<a href="../backend/Gpage.php?page=find&lien='.$lien.'">'.$lien.'</a><br>';
             }       
     }
     if(isset($inArchEtudPreNom)){
        echo 'essayer avec :<br>';
             foreach($inArchEtudPreNom as $lien){
                 echo 
                 '<a href="../backend/Gpage.php?page=find&lien='.$lien.'">'.$lien.'</a><br>';
             }       
     }
     if(isset($archmatricule)){
        echo 'essayer avec :<br>';
             foreach($archmatricule as $lien){
                 echo 
                 '<a href="../backend/Gpage.php?page=find&lien='.$lien.'">'.$lien.'</a><br>';
             }       
     }
}
?>
</div>
<?php
echo $content;
?>


    



    

