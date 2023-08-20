<?php
ob_start();
$id = (int)preg_quote($_GET['idClasse']);
$idSem = (int)preg_quote($_GET['semestre']);
$classe = $databases->requette('SELECT * FROM classe c JOIN filiere f ON c.idFiliere=f.idFiliere WHERE idClasse='.$id);
$classes = $classe->fetch();
$idFiliere = $classes['idFiliere'];
$idAnnee = $classes['idAnnee'];
$active = 1;
$etudiant = $databases->requette('SELECT * FROM etudiant WHERE idClasse='.$id);
include_once 'lienNote.php';
$bouton = new Input('bouton','submit','btn btn-info' ,'Valider','');
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Modification Des Notes</div>
</div>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Notes De La Classe <?=$classes['nomClasse'].'('.$classes['nomFiliere'].')' ?></div>
</div>
<div class="container-fluid">
    <br><br>
        <form action="#" method="post">

            <div class="form-inline">
                <div class=" text-center justify-content-center form-group">
                    <label style="font-size:20px; color:darkslateblue;" class="section_title text-center">Le Semestriel : </label>
                    <select name="semestre" id="" class="form-control">
                        <?php
                        if($idSem === 1){
                            echo '<option value="1">1ere Semestre</option>';
                        }
                        if($idSem === 2){
                            echo '<option value="2">2eme Semestre</option>';
                        }
                        ?>
                        <option value="1">1ere Semestre</option>
                        <option value="2">2eme Semestre</option>
                    </select>
                </div>
            </div>
    <br>
        
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
                           
                                $matiere = $databases->requette('SELECT * FROM matiere WHERE idFiliere='.$idFiliere.' AND idAnnee='.$idAnnee.' AND semestre='.$idSem);
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
                                                        $modnot = $databases->requette('SELECT * FROM note n 
                                                            JOIN etudiant e ON e.matricule=n.matricule
                                                            JOIN matiere m on n.idMatiere=m.idMatiere
                                                            WHERE n.idClasse='.$id.' AND n.matricule='.$mats['matricule'].' AND n.idMatiere='.$matieres['idMatiere']);
                                                            $modnots = $modnot->fetch();

                                                        $name = 'n'.$mats['matricule'].'_'.$matieres['idMatiere'];
                                                        $$name = new Input($name,'','',$modnots['note'],'');
                                                        $$name->InputNote();
                                                        $names [] = $name;
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
            $etudiant = $databases->requette('SELECT * FROM etudiant WHERE idClasse='.$id);
                while($netd = $etudiant->fetch()){
                    $etuds = $databases->requette('SELECT * FROM matiere WHERE idFiliere='.$idFiliere.' AND idAnnee='.$idAnnee.' AND semestre='.$idSem);
                    while($mats = $etuds->fetch()){
                        $name = 'n'.$netd['matricule'].'_'.$mats['idMatiere'];
                        $databases->ReqSecure('UPDATE note SET note=:note,semestre=:semestre WHERE matricule=:mat AND idMatiere=:idMat',
                        [
                            ':note' => $_POST[$$name->getName()],
                            ':semestre' =>$_POST['semestre'],
                            ':mat' => $netd['matricule'],
                            'idMat' => $mats['idMatiere'],
                            
                            
                        ]);
                        header('location: ../backend/Gpage.php?page=affNote&id='.$classes['idClasse']).'stat=1';
                    }
                }
        }     
echo $contentNote;
