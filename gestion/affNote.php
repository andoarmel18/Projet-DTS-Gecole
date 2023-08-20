<?php
$active = null;
require_once 'lienNote.php';
$id = preg_quote($_GET['id']);
$classeId = (int)$id;
$classeData = $databases->getAllData('SELECT * FROM classe c 
    LEFT JOIN filiere f ON c.idFiliere=f.idFiliere
    LEFT JOIN prof p ON p.idProf = c.idProf
    WHERE idClasse='.$classeId);
$idFiliere = $classeData['idFiliere'];
$idAnnee = $classeData['idAnnee'];

?>
<br>
        <div class="col-lg-6 offset-lg-3">
	        <div class="section_title text-center"><?=$classeData['nomClasse'].'('.$classeData['nomFiliere'].')'?></div>
        </div>
        <h3 style="margin-left: 3cm;">Classe sous la responsabilité de 
            <?php if($classeData['sexe'] === 'Feminin'){
                echo 'Madame';
            }else{
                echo 'Monsieur';
            }
            ?>
            <span style="color: black;"> 
            <?=$classeData['nomProf'].' '.$classeData['prenomProf']?>
            </span>
        </h3>
<?php for($i=1 ; $i<=2 ; $i++) : 
$valid = $databases->Chearch('SELECT * FROM note WHERE idClasse='.$classeId.' AND semestre='.$i);
$etudiants = $databases->requette('SELECT e.idClasse, e.matricule, e.nom, e.prenom, m.coeuf, c.idClasse, f.nomFiliere, m.nomMatiere, n.note, n.semestre
FROM etudiant e 
JOIN note n ON n.matricule=e.matricule
JOIN matiere m ON m.idMatiere=n.idMatiere
JOIN filiere f ON f.idFiliere=m.idFiliere
JOIN classe c ON c.idFiliere=f.idFiliere
WHERE n.semestre='.$i.' AND e.idClasse='.$classeId.' GROUP BY e.matricule ORDER BY e.matricule');
$etuds = $databases->requette('SELECT * FROM matiere WHERE idFiliere='.$idFiliere.' AND idAnnee='.$idAnnee.' AND semestre='.$i);
?>
<div class="container">
    <div class="jumbotron">
        <?php
        if($i == 1){
            echo '<h3 style="color: black;">Note Premier Semestre</h3>';
        }
        if($i == 2){
            echo '<h3 style="color: black;">Note Deuxième Semestre</h3>';
        }
        ?>
        
        <br >
        
       
        <table class="table" style="color:black ;" >
            <thead class="thead-dark">
                <tr>
                    <th>Matricule et Prenom</th>
                    <?php while($mat = $etuds->fetch()) : $idMatiere = $mat['idMatiere']?>
                    <th><?=$mat['nomMatiere']?></th>
                    <?php endwhile ?>
                    
                </tr>
            </thead>
            <tbody >
                <?php while($etud = $etudiants->fetch()): $matricule = $etud['matricule']?>
            <tr>
                    <th><?=$etud['matricule']?> : <?=$etud['prenom']?></th>
                    
                    <?php
                    $note = $databases->requette('SELECT note FROM note WHERE matricule='.$matricule.' AND semestre='.$i);
                    ?>
                    <?php while($notes= $note->fetch()) : 
                        $noteStr = str_replace(',','.',$notes['note']);
                        $FloatNote = floatval($noteStr);
                    ?>
                       
                    <th><?=$FloatNote?></th>
                    <?php endwhile ?>
                    
                   
                </tr>
            </tbody>
            <?php endwhile ;?>
        </table>
        <?php if($valid === true) : ?>
            <a class="btn btn-danger" href="../backend/Gpage.php?page=modNote&idClasse=<?=$classeId?>&semestre=<?=$i?>"><span class="fa fa-pencil-square-o"> Modifier</span></a>
            <?php else : ?>
                <a class="btn btn-primary" href="../backend/Gpage.php?page=AjoutNote&id=<?=$classeId?>&&semestre=<?=$i?>"><span class="fa fa-plus-circle"> Ajouter</span></a>
        <?php endif ?>
       
    </div>
</div>
<?php endfor ;?>
