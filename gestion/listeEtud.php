<?php $active = 'let'; 
require_once 'lienAccueil.php';
$etudiants = $databases->requette('SELECT * FROM etudiant e 
    LEFT JOIN classe c ON e.idClasse = c.idClasse
    LEFT JOIN filiere f ON f.idFiliere = c.idFiliere ORDER BY matricule');
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Liste Des Etudiants</div>
    
</div>

<div class="container">
<p>Le nombre total des étudiants est : <?=compter('etudiant')?></p>
	<table class="table">
            <thead class="thead-dark">
            <tr>
                <th>Photo</th>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Filière</th>
                <th>Classe</th> 
				<th>Action</th> 

            </tr>
        </thead>
		<tbody>					
	<?php while($eleve = $etudiants->fetch()):?>
		<tr>
            <td><?='<img   src="../photo/'.$eleve['photo'].'" width="100px" height="100px" class="img-circle">'?></td>
           	<td><?=$eleve['matricule']?></td>
            <td><?=$eleve['nom']?></td>
            <td><?=$eleve['prenom']?></td>
            <td><?=$eleve['nomFiliere']?></td>
            <td><?=$eleve['nomClasse']?></td>
			<td>
            <a style="color: white; " class="fa fa-info btn btn-primary" href="Gpage.php?page=infoEtudiant&id=<?=$eleve['matricule']?>"></a>
            <a style="color: white; " class="fa fa-pencil-square-o btn btn-success" href="Gpage.php?page=modifier&id=<?=$eleve['matricule']?>"></a>
            <a style="color: white; " class="fa fa-trash btn btn-danger" href="Gpage.php?page=confDel&id=<?=$eleve['matricule']?>&action=delEtd"></a>
            </td>
    	</tr>					
	<?php endwhile;?>
		</tbody>	
	</table>
	</div>
							