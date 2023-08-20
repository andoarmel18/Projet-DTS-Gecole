<?php
$active = 4;
include_once 'lienPointage.php';
?>
<div class="container">
    <div class="jumbotron">
        <form action="" method="post">
            <div style="width: 6cm;display:flex;" class="form-group">
                <input type="date" name="filtre" id="" class="form-control">
                <button class="btn btn-success btn-xm" type="submit"><span class="fa fa-search"></span></button>
            </div>
            
        </form>
        <div class="card table-responsive">
            <table class="table table-bordered"> 
                <thead class="thead-dark"> 
                    <tr> 
                        <th>Matricule</th> 
                        <th>Nom</th> 
                        <th>Prenom</th>
                        <th>Classe</th> 
                        <th>Matiere</th> 
                        <th>Date</th>
                    </tr> 
                </thead> 
                <tbody>         
                <?php
                if(!empty($_POST['filtre'])){
                    $retard = $databases->requette('SELECT * FROM absence ab 
                        JOIN matiere m ON m.idMatiere=ab.idMatiere
                        JOIN etudiant e ON e.matricule=ab.matricule
                        JOIN classe c ON e.idClasse=c.idClasse
                        JOIN filiere f ON f.idFiliere=c.idFiliere
                        WHERE dateAbs="'.$_POST['filtre'].'" AND ab.idMatiere!=0
                        ORDER BY dateAbs');
                }else{
                    $retard = $databases->requette('SELECT * FROM absence ab 
                    JOIN matiere m ON m.idMatiere=ab.idMatiere
                    JOIN etudiant e ON e.matricule=ab.matricule
                    JOIN classe c ON e.idClasse=c.idClasse
                    JOIN filiere f ON f.idFiliere=c.idFiliere
                    WHERE ab.idMatiere!=0 ORDER BY dateAbs');
                }
                    
                while($retards = $retard->fetch()) : ?>
                    <tr> 
                        <th><?=$retards['matricule']?></th> 
                        <th><?=$retards['nom']?></th> 
                        <th><?=$retards['prenom']?></th> 
                        <th><?=$retards['nomClasse'].' ('.$retards['nomFiliere'].')'?></th>
                        <th><?=$retards['nomMatiere']?></th> 
                        <th><?=$retards['dateAbs']?></th> 
                    </tr> 
                <?php endwhile?>   
                </tbody> 
            </table> 
        </div> 
    </div>
</div>