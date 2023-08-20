<?php
$active = null;
require_once 'lienAccueil.php';
$id = preg_quote($_GET['id']);
$int = (int)$id;
$classes = $databases->getAllData('SELECT * FROM classe c 
    LEFT JOIN filiere f ON c.idFiliere=f.idFiliere
    LEFT JOIN prof p ON c.idProf=p.idProf
    WHERE idClasse='.$int);
$etudiants = $databases->requette('SELECT * FROM etudiant e 
    JOIN classe c ON e.idClasse=c.idClasse 
    JOIN filiere f ON f.idFiliere=c.idFiliere
    WHERE e.idClasse='.$int);
$mois = $databases->requette('SELECT * FROM mois ORDER BY idMois');
if(isset($_GET['source']) AND $_GET['source'] === 'archive'){
    $classes = $databases->getAllData('SELECT * FROM archive a JOIN filiere f ON a.idFiliere=f.idFiliere
        LEFT JOIN prof p ON a.idProf=p.idProf
        WHERE idClasse='.$int);
    $etudiants = $databases->requette('SELECT * FROM archive a 
        LEFT JOIN classe c ON a.idClasse=c.idClasse 
        LEFT JOIN filiere f ON f.idFiliere=a.idFiliere
        WHERE a.idClasse='.$int);
}
?>
<div class="container">
    <div class="jumbotron">
        <div class="col-lg-6 offset-lg-3">
	        <div class="section_title text-center"><?=$classes['nomClasse'].'('.$classes['nomFiliere'].')'?></div>
        </div>
        <br>
        <h3>Classe sous la responsabilité de 
            <?php if($classes['sexe'] === 'Feminin'){
                echo 'Madame';
            }else{
                echo 'Monsieur';
            }
            ?>
            <span style="color: black;"> 
            <?=strtoupper( $classes['nomProf']).' '.ucfirst($classes['prenomProf'])?>
            </span>
        </h3>
       
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Date de Naissance</th>
                    <th>Mail</th>
                    <th>Numéro</th>
                </tr>
            </thead>
            <tbody>
                <?php while($etud = $etudiants->fetch()):?>
            <tr>
                    <th><?=$etud['matricule']?></th>
                    <th><?=$etud['nom']?></th>
                    <th><?=$etud['prenom']?></th>
                    <th><?=$etud['dateNaiss']?></th>
                    <th><?=$etud['mail']?></th>
                    <th><?=$etud['numero']?></th>
                </tr>
            </tbody>
            <?php endwhile ;?>
        </table>
       
    </div>
</div>

<div class="container">
    <button id="fclasse" class="btn btn-warning form-group">Les Payement FF</button>
</div>

<div id="p1" class="container">
    <div>
        <table>
            <thead>
                <tr><th class="table-success">PAYER</th></tr>
                <tr><th class="table-danger">NON PAYER</th></tr>  
            </thead>
        </table>
    </div>
    <div class="alert alert-warning">
        <div class="col-lg-6 offset-lg-3">
	        <div class="section_title text-center">Fiche D'Ecolage</div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered"> 
            <thead> 
                <tr> 
                    <th class="table-light" style="color:black">Matricule</th>
                    <?php while($month = $mois->fetch()) :?>
                        <th class="table-dark"><?=$month['mois']?></th>
                    <?php endwhile?> 
                </tr> 
            </thead>
            <tbody>
                <?php
                $etudiants = $databases->requette('SELECT * FROM etudiant e 
                    JOIN classe c ON e.idClasse=c.idClasse 
                    JOIN filiere f ON f.idFiliere=c.idFiliere
                    WHERE e.idClasse='.$int);
                while($etud = $etudiants->fetch()) : $matricule = $etud['matricule'] 
                ?> 
                    <tr> 
                        <th style="color: black;"><?=$etud['matricule']?></th> 
                <?php 
                    $mois = $databases->requette('SELECT * FROM mois ORDER BY idMois');
                    while($month = $mois->fetch()) : 
                        $idMois = $month['idMois'];
                        $stat = $databases->Chearch('SELECT * FROM ecolage e
                        JOIN annee a ON a.idAnnee=e.idAnnee
                        JOIN classe c ON c.idAnnee=a.idAnnee 
                        WHERE idMois='.$idMois.' AND matricule='.$matricule.' AND c.idClasse='.$int);
                ?>
                        <?php if($stat === true) :?>
                            <th class="table-success"></th>
                        <?php else : ?>
                            <th class="table-danger"></th>
                        <?php endif?>
                    <?php endwhile?> 
                        </tr>
                <?php endwhile?> 
                </tbody> 
            </table>
        </div>
    </div>
</div>
    


