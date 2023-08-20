<?php
ob_start();
$active = 'le';
include_once 'lienPayement.php';
?>

<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Liste des Payements Effectué</div>
</div>

<div class="container col-md-12">
   
   
    <div class="jumbotron col-md-12">
       
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table col-md-12 sm-12" style="color: black;">
                        <thead class="thead-dark">
                            <tr>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prenom</th> 
                                <th>Classe</th>
                                <th>Filiere</th>
                                <th>Montant</th>
                                <th>Mois du</th>
                                <th>Date de Payment</th> 
                                <th>Payment De</th> 
                                <th></th>     
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $allpay = $databases->requette('SELECT * FROM ecolage ec 
                            JOIN mois m ON ec.idMois=m.idMois
                            JOIN annee a ON a.idAnnee=ec.idAnnee
                            JOIN etudiant e ON e.matricule=ec.matricule
                            JOIN classe c ON c.idClasse=e.idClasse
                            JOIN filiere f ON c.idFiliere=f.idFiliere ORDER BY idEcolage DESC');
                            While($al = $allpay->fetch()):
                            ?>
                            <tr>
                                <td><?=$al['matricule']?></td>
                                <td><?=$al['nom']?></td>
                                <td><?=$al['prenom']?></td> 
                                <td><?=$al['nomClasse']?></td>
                                <td><?=$al['nomFiliere']?> </td>
                                <td><?=$al['montant']?> </td>
                                <td><?=$al['mois']?> </td>
                                <td><?=$al['dateP']?></td>
                                <td><?=$al['typepay']?></td>
                                <th style="display: flex;">
                                    <a href="../backend/Gpage.php?page=modPay&id=<?=$al['idEcolage']?>" class="btn btn-info"><span class="fa fa-pencil-square-o"></span></a>
                                    <a href="../backend/Gpage.php?page=confDel&id=<?=$al['idEcolage']?>&action=delPay" class="btn btn-danger"><span class="fa fa-trash"></span></a>
                                    <a href="../fpdf184/facture.php?id=<?=$al['idEcolage']?>" class="btn btn-success"><span class="fa fa-print"></span></a>
                                </th>    
                            </tr>
                            <?php endwhile?>
                        </tbody>
                    </table>
                </div>
            </div>  
    </div>
</div>
<?php
$content = ob_get_clean();
echo $content;