<?php
$active = 3;
include_once 'lienProf.php';
$annee = $databases->requette('SELECT * FROM annee');
$filiere = $databases->requette('SELECT * FROM filiere ORDER BY idFiliere DESC');
$prof = $databases->requette('SELECT * FROM prof ORDER BY nomProf');

?>
<div class="container-fluid">
    <div class="jumbotron">
        <div class="card">
            <p style="color: black;">Nombre Total des Matieres : <?=compter('matiere')?></p>
            <p style="color: black;">Nombre Total des Filieres : <?=compter('filiere')?></p>
                <br>
            <div class="table-responsive">
            <table class="table table-bordered"> 
                <thead> 
                    <tr> 
                        <th  class="table-light"></th>
                        <?php while($annees = $annee->fetch()) :  ?>
                        <th class="table-dark"><?=$annees['annee']?></th> 
                        <?php endwhile ?>
                    </tr> 
                </thead> 
                <tbody>
                    <?php while($filieres = $filiere->fetch()) : 
                        $idFiliere=$filieres['idFiliere'];
                        $annee = $databases->requette('SELECT * FROM annee');
                        ?>
                    <tr> 
                        <th class="table-dark">
                            <?=$filieres['nomFiliere']?>
                            <a style="color: red;" href="../backend/Gpage.php?page=confDel&action=delFil&id=<?=$idFiliere?>"><span class="fa fa-trash"></span></a>
                            <a style="color: green;" href="../backend/Gpage.php?page=modFiliere&id=<?=$idFiliere?>"><span class="fa fa-pencil-square"></span></a>
                        </th>
                        <?php while($annees = $annee->fetch()) : $idAnnee=$annees['idAnnee'] ?>
                        <th>
                            <?php
                            $matiere = $databases->requette('SELECT * FROM matiere WHERE idFiliere='.$idFiliere.' AND idAnnee='.$idAnnee.' AND semestre=1');
                            ?>
                        <div style="display: flex;">
                        <ul class="border-right border-bottom border-info">
                            <h4 class="border-bottom border-info"><b>Première Semestre</b></h4>
                            <?php while($matieres = $matiere->fetch()) : ?>
                            <li style="display: flex;"><?='<strong style="color:black;">'.$matieres['nomMatiere'].'</strong> coeuf('.$matieres['coeuf'].')'?> 
                            
                            <a style="color: green;" href="../backend/Gpage.php?page=modMatiere&id=<?=$matieres['idMatiere']?> "><span class="fa fa-pencil-square"></span></a>
                            <a href="../backend/Gpage.php?page=confDel&id=<?=$matieres['idMatiere']?>&action=delMat" style="color: red;"><span class="fa fa-trash"></span></a>
                            </li>
                            <br>
                            <?php endwhile ?>
                        </ul>
                        <?php
                            $matiere = $databases->requette('SELECT * FROM matiere WHERE idFiliere='.$idFiliere.' AND idAnnee='.$idAnnee.' AND semestre=2');
                            ?>
                        <ul class="border-bottom border-info" style="width: 4.5cm;">
                            <h4 class="border-bottom border-info"><b>Deuxième Semestre</b></h4>
                            <?php while($matieres = $matiere->fetch()) : ?>
                            <li style="display: flex;"><?='<strong style="color:black;">'.$matieres['nomMatiere'].'</strong> coeuf('.$matieres['coeuf'].')'?> 
                            
                            <a style="color: green;" href="../backend/Gpage.php?page=modMatiere&id=<?=$matieres['idMatiere']?> "><span class="fa fa-pencil-square"></span></a>
                            <a href="../backend/Gpage.php?page=confDel&id=<?=$matieres['idMatiere']?>&action=delMat" style="color: red;"><span class="fa fa-trash"></span></a>
                            </li>
                            <br>
                            <?php endwhile ?>
                        </ul>
                        </div><br>
                                <a href="../backend/Gpage.php?page=AjoutMatiere&idfiliere=<?=$idFiliere?>&idAnnee=<?=$idAnnee?>"><li class="fa fa-plus btn btn-info d-flex justify-content-center">Ajouter</li></a>    
                        
                        </th> 
                        <?php endwhile ?>
                    </tr> 
                    <?php endwhile ?>  
                </tbody> 
            </table>
            
            </div>
            <a href="../backend/Gpage.php?page=AjoutFiliere" class="btn btn-danger"><span class="fa fa-plus"></span>Ajouter Filiere</a><br>
        </div>
    <br>
       
        
        

