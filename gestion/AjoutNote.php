<?php
ob_start();
$id = (int)preg_quote($_GET['id']);
$semestre = (int)preg_quote($_GET['semestre']);
$classe = $databases->requette('SELECT * FROM classe c JOIN filiere f ON c.idFiliere=f.idFiliere WHERE idClasse='.$id);
$classes = $classe->fetch();
$idFiliere = $classes['idFiliere'];
$idAnnee = $classes['idAnnee'];
$active = 1;
$etudiant = $databases->requette('SELECT * FROM etudiant WHERE idClasse='.$id);
include_once 'lienNote.php';
$bouton = new Input('bouton','submit','btn btn-info' ,'Valider','');
$sem = null;
$erreur = null;
$heveError = null;
?>


<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Notes De La Classe <?=$classes['nomClasse'].'('.$classes['nomFiliere'].')' ?></div>
</div>
<div class="container-fluid">
    <br><br>
        <form action="#" method="post">
            <div  style="display: flex;">
                <!--DEBUT DES NOM ET MATRICULE DES ELEVES-->
                <div>
                    <p style="color: black;">Mat et Prenom</p>
                        <div class="form-group" style="margin-top: 0.5cm;">
                            <!--DEBUT BOUCLES A PARCOURIR LES ELEVE UTILISE-->
                            <?php while($etudiants = $etudiant->fetch()) :?>
                            <div  style="height: 1cm;">
                                <tr class="form-group border-bottom m-1 p-1 border-info">
                                <?php
                                echo $etudiants['matricule'].' : ';
                                if(strlen($etudiants['prenom'])> 10) {
                                   echo substr($etudiants['prenom'],0,8).'...';
                                }else{
                                   echo $etudiants['prenom'];
                                }   
                                ?>
                                </tr> 
                            </div>
                            
                            <?php endwhile?>
                            <!--FIN DU BOUCLE-->
                        </div>
                </div>
                <!--FIN A PROPOS DES ELEVES-->

                            <!--A PrOPOS DES MATIERES-->
                            <?Php
                           
                                $matiere = $databases->requette('SELECT * FROM matiere WHERE idFiliere='.$idFiliere.' AND idAnnee='.$idAnnee.' AND semestre='.$semestre);
                            ?>
                                    <!--BOUCLE PARCOURIR LES MATIERE UTILISE-->
                                <?php while($matieres = $matiere->fetch()) :?>
                                    <div class="border-right m-1 p-1 border-info" style="margin-top:2cm;">
                                        <th style="color: black;"><?=$matieres['nomMatiere']?> </th> 
                                            <?Php
                                                $etuds = $databases->requette('SELECT * FROM etudiant WHERE idClasse='.$id);
                                            ?>
                                            <!--LES NOMBRE DES INPUT PAR RAPPORT AU NBR DES ETUDIANT ET LES MATIERE-->
                                                <?php 
                                                    while($mats = $etuds->fetch()) {
                                                        $name = 'n'.$mats['matricule'].'_'.$matieres['idMatiere'];
                                                        $$name = new Input($name,'','','','    /20');
                                                        $$name->InputNote();
                                                        $names [] = $name;
                                                        if(!empty($_POST[$$name->getName()])){
                                                            if(!preg_match('/(,{1})^[0-9]$|^[0-9]/',$_POST[$$name->getName()])){
                                                               header('location: ../backend/Gpage.php?page=AjoutNote&stat=6&id='.$id);
                                                               die();
                                                            }
                                                        }
                                                       
                                                    } 
                                                ?>
                                         <!--FIN DU BOUCLE DES INPUT PAR RAPPORT AU NBR DES ETUDIANT ET LES MATIERE-->
                                    </div>
                                <?php endwhile?> 
                                <!--FIN DU BOUCLE PARCOURIR LES MATIERE UTILISE-->
                                <br>                                            
            </div>
        <!--BOUTTON-->
        <?php 
            $bouton->CreatInput('','');
        ?>
        <br>
        </form>
    </div>
</div>
<br>
<br>

<?php 
$contentNote = ob_get_clean();
$findNote [] = null;
$stat = $databases->requette('SELECT semestre FROM note WHERE idClasse='.$id.' GROUP BY semestre');
while($stats = $stat->fetch()){
    $findNote[] = $stats['semestre'];
}


        
        if(!empty($_POST[$bouton->getName()])){
            if(!in_array($semestre,$findNote)){
                $etudiant = $databases->requette('SELECT * FROM etudiant WHERE idClasse='.$id);
                while($netd = $etudiant->fetch()){
                    $matiere = $databases->requette('SELECT * FROM matiere WHERE idFiliere='.$idFiliere.' AND idAnnee='.$idAnnee.' AND semestre='.$semestre);
                    while($mats = $matiere->fetch()) {
                        $name = 'n'.$netd['matricule'].'_'.$mats['idMatiere'];
                                $databases->ReqSecure('INSERT INTO note(matricule,idMatiere,note,semestre,idClasse)
                                VALUES (:mat, :idMat, :note , :semestre , :idClasse)' ,
                                    [
                                        ':mat' => $netd['matricule'],
                                        'idMat' => $mats['idMatiere'],
                                        ':note' => $_POST[$$name->getName()],
                                        ':semestre' =>$semestre,
                                        ':idClasse' => $id
                                    ]);
                                    header('location: ../backend/Gpage.php?page=affNote&id='.$classes['idClasse']);
                            }
                        }
                    }else{
                        if($semestre == 1){
                        $sem = '1er Semestre';
                        }
                        if($semestre == 2){
                        $sem = '2eme Semestre';
                        }
                        echo '<script>
                            alert("Cette Classe a déjat de note '.$sem.'");
                            </script>';
                    }
                }
            
echo $contentNote;
