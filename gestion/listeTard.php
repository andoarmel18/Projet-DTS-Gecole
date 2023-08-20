<?php
$active = 2;
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
            <table class="table"> 
                <thead class="thead-dark"> 
                    <tr> 
                        <th>Matricule</th> 
                        <th>Matiere</th> 
                        <th>Classe</th> 
                        <th>Heure D'enter</th> 
                        <th>Durer De retard</th>
                        <th>Date</th>
                        <th>Motif</th>
                    </tr> 
                </thead> 
                <tbody>         
                <?php
                if(!empty($_POST['filtre'])){
                    $retard = $databases->requette('SELECT * FROM retard r 
                        JOIN matiere m ON r.idMatiere=m.idMatiere
                        JOIN etudiant e ON e.matricule=r.matricule
                        JOIN classe c ON e.idClasse=c.idClasse
                        WHERE date="'.$_POST['filtre'].'"');
                }else{
                    $retard = $databases->requette('SELECT * FROM retard r 
                        JOIN matiere m ON r.idMatiere=m.idMatiere
                        JOIN etudiant e ON e.matricule=r.matricule
                        JOIN classe c ON e.idClasse=c.idClasse');
                }
                    
                while($retards = $retard->fetch()) : ?>
                    <tr> 
                        <th><?=$retards['matricule']?></th> 
                        <th><?=$retards['nomMatiere']?></th> 
                        <th><?=$retards['nomClasse']?></th> 
                        <th><?=$retards['heureEntrer']?></th>
                        <th><?=$retards['durer_retard']?></th> 
                        <th><?=$retards['date']?></th> 
                        <th><?=$retards['motif']?></th> 
                    </tr> 
                <?php endwhile?>   
                </tbody> 
            </table> 
        </div> 
    </div>
</div>