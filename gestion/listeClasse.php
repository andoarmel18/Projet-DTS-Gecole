<?php
$active = 'lcls';
require_once 'lienAccueil.php';
$cls = $databases->requette('SELECT * FROM classe c JOIN filiere f ON c.idFiliere=f.idFiliere GROUP BY c.idFiliere');
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Liste Des Classes</div>
</div>
<div class="container">
    <div class="col-12 mt-5">
        <p>Le nombre total des classes est : <?=compter('classe')?></p> 
            <?php while($classe1 = $cls->fetch()) :
                
                    $idFiliere = $classe1['idFiliere'];
                    $flr = $databases->requette('SELECT * FROM classe c 
                        JOIN filiere f 
                        ON c.idFiliere = f.idFiliere
                        WHERE c.idFiliere = '.$idFiliere.' 
                        GROUP BY c.idFiliere,c.idClasse ORDER BY nomClasse');
                        //une requette compte des etudiant par classe
                ?>
                        <h3 style="color: black;"><?=$classe1['nomFiliere']?></h3>
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nom de la Classe</th>
                                            <th>Nombre des élèves</th>
                                            <th>Années Scolaire</th>
                                            <th>Action</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($flrs = $flr->fetch()):?>
                                            <?php
                                            $idClasse = $flrs['idClasse'];
                                            $etds = $databases->requette('SELECT COUNT(*) AS ligne FROM etudiant e JOIN classe c ON e.idClasse=c.idClasse WHERE e.idClasse ='.$idClasse);
                                            ?>
                                            <tr>
                                                <td><?=$flrs['nomClasse']?></td>
                                            <!--un boucle qui compte les ligne donné par un requette count-->
                                            <?php while($etds1 = $etds->fetch()) : ?>
                                                <td><?=$etds1['ligne']?></td>
                                            <?php endwhile; ?>
                                                <td><?=$flrs['annee_scolaire']?></td>
                                                <td>
                                                    <a style="color: white; " class="fa fa-info btn btn-primary" href="Gpage.php?page=infoClasse&id=<?=$flrs['idClasse']?>"></a>
                                                    <a style="color: white; " class="fa fa-pencil-square-o btn btn-success" href="Gpage.php?page=modClasse&id=<?=$flrs['idClasse']?>"></a>
                                                    <a style="color: white; " class="fa fa-archive btn btn-warning" href="Gpage.php?page=confDel&id=<?=$flrs['idClasse']?>&action=archive"></a>
                                                    <a style="color: white; " class="fa fa-trash btn btn-danger" href="Gpage.php?page=confDel&id=<?=$flrs['idClasse']?>&action=delClasse"></a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>  
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
            <?php endwhile; ?>
    </div>
</div>
<br>
<br>