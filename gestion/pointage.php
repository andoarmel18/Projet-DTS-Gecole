<?php
$active = 1;
include_once 'lienPointage.php';
$databases->requette('DELETE FROM conmdp');
$eleve = $databases->requette('SELECT * FROM etudiant');
$matiere = $databases->requette('SELECT * FROM matiere');
$in_tard = [];
?>
<div class="container">
    <div style="display: flex;" class="jumbotron">
        <div class="col-md-4">
            <form action="" method="POST">
                <?php
                $etds = new Input('etd','','form-control','','');
                $etds->CreatSelect('Etudiants : ','form-group','matricule','nom','prenom',$eleve,'','');
                //====================================================================================
                $mat = new Input('mat','','form-control','','');
                $mat->CreatSelect('Matiere : ','form-group','idMatiere','nomMatiere','',$matiere,'','');
                //====================================================================================
                $heure = new Input('heure','time','form-control','','');
                $heure->CreatInput('Heure D\'enter : ','form-group');
                //====================================================================================
                $dure = new Input('dure','texte','form-control','','');
                $dure->CreatInput('Duré Du Retard : ','form-group');
                //====================================================================================
                ?>
                <div class="form-group">
                <label style="font-size:20px; color:darkslateblue;" class="section_title text-center">Motif De Retard</label>
                    <textarea name="motif" id="" cols="10" rows="10" class="form-control">

                    </textarea>
                </div>
                
                <?php
                $btn = new Input('btn','submit','btn btn-info','Valider');
                $btn->CreatInput('','');
                ?>
            </form>

        </div>
        <div class="col-md-8">
            <div class="card table-responsive">
                <h3>Liste De Retard Aujourd'hui</h3>
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
                            $retard = $databases->requette('SELECT * FROM retard r 
                                JOIN matiere m ON r.idMatiere=m.idMatiere
                                JOIN etudiant e ON e.matricule=r.matricule
                                JOIN classe c ON e.idClasse=c.idClasse
                                WHERE date="'.date('Y-m-d').'"');
                            while($retards = $retard->fetch()) : 
                            ?>
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
</div>
<?php
if (!empty($_POST[$etds->getName()]) AND !empty($_POST[$mat->getName()]) AND !empty($_POST[$heure->getName()]) AND !empty($_POST[$dure->getName()])) {
    $tardNow = $_POST[$etds->getName()].$_POST[$mat->getName()].$_POST[$heure->getName()].date('Y-m-d');
        $tard = $databases->requette('SELECT * FROM retard');
        while ($tards = $tard->fetch()) {
            $in_tard [] = $tards['matricule'].$tards['idMatiere'].$tards['heureEntrer'].$tards['date'];
        }
            if(!in_array($tardNow,$in_tard) OR (int)compter('retard') < 1){
                $databases->ReqSecure('INSERT INTO retard (matricule,idMatiere,heureEntrer,durer_retard,date,motif)
                     VALUES (:matricule,:matiere,:heure,:dure,:date,:motif)',
                        [
                            ':matricule' => $_POST[$etds->getName()],
                            ':matiere' => $_POST[$mat->getName()],
                            ':heure' => $_POST[$heure->getName()],
                            ':dure' => $_POST[$dure->getName()],
                            ':date' => date('Y-m-d'),
                            ':motif' =>$_POST['motif']
                        ]);
                            header('location: ../backend/Gpage.php?page=pointage');
            }
     
}
