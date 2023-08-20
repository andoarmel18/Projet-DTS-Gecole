<div id="err">
<?php
$id = (int)$_GET['id'];
$mot = 'SUPPRIMER';
if(isset($_GET['action'])){
    if($_GET['action'] === 'delEtd'){
        $etudiant = $databases->getAllData('SELECT * FROM etudiant WHERE matricule='.$id);
        $span = 'LE MATRICULE : <i style="color:red">'.$etudiant['matricule'].'</i> ?';
    }
    if($_GET['action'] === 'delClasse'){
        $classe = $databases->getAllData('SELECT * FROM classe c
        JOIN filiere f ON f.idFiliere=c.idFiliere
        WHERE idClasse='.$id);
        $span = 'LA CLASSE : <i style="color:red">'.$classe['nomClasse'].' ('.$classe['nomFiliere'].')</i> ?';
    }
    if($_GET['action'] === 'delPay'){
        $payement = $databases->getAllData('SELECT * FROM ecolage WHERE idEcolage='.$id);
        $span = 'LA PAYEMENT DE MATRICULE : <i style="color:red">'.$payement['matricule'].'</i>, LE <i style="color:red">'.$payement['dateP'].'</i> ?';
    }
    if($_GET['action'] === 'delFil'){
        $filiere = $databases->getAllData('SELECT * FROM filiere WHERE idFiliere='.$id);
        $span = nl2br('LA FILIERE : <i style="color:red">'.$filiere['nomFiliere'].'</i>  ?
        ATTENTION SI VOUS VOULEZ LA SUPRIMER TOUS LES CLASSE ET LES MATIERES
        CORRESPONDANTS SONT DETRUIT');  
    }
    if($_GET['action'] === 'delMat'){
        $mat = $databases->getAllData('SELECT * FROM matiere m
        JOIN annee a ON m.idAnnee=a.idAnnee
        WHERE idMatiere='.$id);
        $span = 'LA MATIERE : <i style="color:red">'.$mat['nomMatiere'].'</i> DE TOUS LES CLASSE <i style="color:red">'.$mat['annee'].'</i> ?';
    }
    if($_GET['action'] === 'delProf'){
        $prof = $databases->getAllData('SELECT * FROM prof WHERE idProf='.$id);
        if($prof['sexe'] === 'Masculin'){
            $sexe = 'Mr';
        }
        if($prof['sexe'] === 'Feminin'){
            $sexe = 'Mdm';
        }
        $span = $sexe.'<i style="color:red"> '.strtoupper($prof['nomProf']).' '.ucfirst($prof['prenomProf']).'</i> ?';
    }
    if($_GET['action'] === 'delEmp'){
        $emploi = $databases->getAllData('SELECT c.nomClasse,edt.idClasse,nomFiliere FROM emploi_du_temp edt 
        JOIN classe c ON edt.idClasse=c.idClasse
        JOIN filiere f ON c.idFiliere=f.idFiliere
        WHERE edt.idClasse='.$id.' GROUP BY edt.idClasse');
        $span = 'L\' EMPLOI DU TEMPS DE LA CLASSE <i style="color:red">'.$emploi['nomClasse'].'('.$emploi['nomFiliere'].')</i> ?';
    }
    if($_GET['action'] === 'archive'){
        $classe = $databases->getAllData('SELECT * FROM classe c
        JOIN filiere f ON f.idFiliere=c.idFiliere
        WHERE idClasse='.$id);
        $mot = 'DEPLACER EN ARCHIVE';
        $span = 'LA CLASSE : <i style="color:red">'.$classe['nomClasse'].' ('.$classe['nomFiliere'].')</i> ?';
    }
}

?>
</div>
<div style="margin-top: 3cm;" class="container">
    <div class="jumbotron">
        <div class="alert alert-danger">
            <strong>VOULEZ VOUS <?=$mot.' '.$span?></strong>
            <form action="" method="post">
                <div class="d-flex  justify-content-end">
                    <button type="submit" value="oui" name="btn" class="btn btn-danger form-group">OUI</button>
                    <button type="submit" value="non" name="btn" class="btn btn-info form-group">NON</button>
                </div>
            </form> 
        </div>
    </div>
</div>
<?php
if(!empty($_POST['btn'])){
    if($_POST['btn'] === 'oui'){
        //suppr etudiant
        if($_GET['action'] == 'delEtd'){
            $databases->requette('DELETE FROM ecolage WHERE matricule='.$id);
            $databases->requette('DELETE FROM note WHERE matricule='.$id);
            $databases->requette('DELETE FROM etudiant WHERE matricule='.$id);
            header('location: ../backend/Gpage.php?page=listeEtud&stat=1');
        }
        //suppr classe
        if($_GET['action'] == 'delClasse'){
            $databases->requette('DELETE FROM classe WHERE idClasse='.$id);
            $databases->requette('DELETE FROM emploi_du_temp WHERE idClasse='.$idC);
            header('location: ../backend/Gpage.php?page=listeClasse&stat=1');
        }
        //suppr payement
        if($_GET['action'] == 'delPay'){
            $databases->requette('DELETE FROM ecolage WHERE idEcolage='.$id);
            header('location: ../backend/Gpage.php?page=listePayement&stat=1');
        }
        //suppr filiere
        if($_GET['action'] == 'delFil'){
            $idClasse = $databases->requette('SELECT idClasse FROM classe WHERE idFiliere='.$id);
            while ($idClasses = $idClasse->fetch()) {
               $idC = $idClasses['idClasse'];
               $databases->requette('DELETE FROM emploi_du_temp WHERE idClasse='.$idC);
            }
            $note = $databases->requette('SELECT idNote FROM note n
            JOIN matiere m ON n.idMatiere=m.idMatiere WHERE m.idFiliere='.$id);
            while ($notes=$note->fetch()) {
                $idNote = $notes['idNote'];
                $databases->requette('DELETE FROM note WHERE idNote='.$idNote);
            }
            $databases->requette('DELETE FROM matiere WHERE idFiliere='.$id);
            $databases->requette('DELETE FROM classe WHERE idFiliere='.$id);
            $databases->requette('DELETE FROM filiere WHERE idFiliere='.$id);
            header('location: ../backend/Gpage.php?page=LprofMat&stat=1');
        }
        //suppr matiere
        if($_GET['action'] === 'delMat'){
            $databases->requette('DELETE FROM note WHERE idMatiere='.$id);
            $databases->requette('DELETE FROM matiere WHERE idMatiere='.$id);
            header('location: ../backend/Gpage.php?page=LprofMat&stat=1');
        }
        //suppr prof
        if($_GET['action'] === 'delProf'){
            $databases->requette('DELETE FROM profmat WHERE idProf='.$id);
            $databases->requette('DELETE FROM prof WHERE idProf='.$id);
            header('location: ../backend/Gpage.php?page=Lprof&stat=1');
        }
        //suppr emlpoi du temp
        if($_GET['action'] === 'delEmp'){
            $databases->requette('DELETE FROM emploi_du_temp WHERE idClasse='.$id);
            header('location: ../backend/Gpage.php?page=emploiClasse&id='.$id.'&stat=1');
        }
        //archive
        if($_GET['action'] == 'archive'){
            $arch_classe = $databases->getAllData('SELECT * FROM classe WHERE idClasse='.$id);
            $databases->reqSecure('INSERT INTO arch_classe(idClasse,nomClasse,idFiliere,idProf,idAnne)
               VALUES (:idclasse,:classe, :filiere, :prof, :annee)',
                [
                    ':idclasse' => $arch_classe['idClasse'],
                    ':classe' => $arch_classe['nomClasse'],
                    ':filiere' => $arch_classe['idFiliere'],
                    ':prof' => $arch_classe['idProf'],
                    ':annee' => $arch_classe['idAnnee'],
                ]);
            $arch_etudiant = $databases->requette('SELECT * FROM etudiant WHERE idClasse='.$id);
            $arch_emploi = $databases->requette('SELECT * FROM emploi_du_temp WHERE idClasse='.$id);
            while($arch_emplois = $arch_emploi->fetch()){
                $databases->reqSecure('INSERT INTO arch_emploi_du_temp(idProfMat,idClasse,idHeure,idJour)
                     VALUES (:pm, :classe, :heure, :jour)',
                            [
                                ':pm' =>$arch_emplois['idProfMat'],
                                ':classe' => $arch_emplois['idClasse'],
                                ':heure' => $arch_emplois['idHeure'],
                                ':jour' => $arch_emplois['idJour']
                            ]);
            }
            while($arch_etudiants = $arch_etudiant->fetch()){
                $matEtd = $arch_etudiants['matricule'];
                $databases->reqSecure('INSERT INTO arch_etud(matricule,photo,nom,prenom,sexe,dateNaiss,lieuNaiss,numero,mail,adresse,pere,mere,idClasse)
                VALUES(:mat,:photo,:nom,:prenom,:sexe,:daten,:ln,:num,:mail,:adresse,:pere,:mere,:idClasse)',
                [
                    ':mat' => $arch_etudiants['matricule'],
                    ':photo' => $arch_etudiants['photo'],
                    ':nom' => $arch_etudiants['nom'],
                    ':prenom' => $arch_etudiants['prenom'],
                    ':sexe' => $arch_etudiants['sexe'],
                    ':daten' => $arch_etudiants['dateNaiss'],
                    ':ln' => $arch_etudiants['lieuNaiss'],
                    ':num' => $arch_etudiants['numero'],
                    ':mail' => $arch_etudiants['mail'],
                    ':adresse' => $arch_etudiants['adresse'],
                    ':pere' => $arch_etudiants['pere'],
                    ':mere' => $arch_etudiants['mere'],
                    ':idClasse' => $arch_etudiants['idClasse']
                ]);
                $arch_note = $databases->requette('SELECT * FROM note WHERE matricule='.$matEtd);
                    while($arch_notes = $arch_note->fetch()){
                        $databases->reqSecure('INSERT INTO arch_note(matricule,idMatiere,note,semestre,idClasse) 
                            VALUES (:mat,:idMat,:note,:semestre,:idClasse)',
                            [
                                ':mat' => $arch_notes['matricule'],
                                ':idMat' => $arch_notes['idMatiere'],
                                ':note' => $arch_notes['note'],
                                ':semestre' => $arch_notes['semestre'],
                                'idClasse' => $arch_notes['idClasse']
                            ]);
                    }
                $arch_pay = $databases->requette('SELECT * FROM ecolage WHERE matricule='.$matEtd);
                    while($arch_pays = $arch_pay->fetch()){
                        $databases->ReqSecure('INSERT INTO arch_ecolage(montant, dateP, idMois, idAnnee, matricule)
			                VALUES (:montant, :dateP , :mois, :annee, :matricule)',
				                [
				                    ':montant' => $arch_pays['montant'],
				                    ':dateP' => $arch_pays['dateP'],
				                    ':mois' =>  $arch_pays['idMois'],
				                    ':annee'  => $arch_pays['idAnnee'],
				                    ':matricule' => $arch_pays['matricule']
				                ]);
                    }
                $arch_ab = $databases->requette('SELECT * FROM absence WHERE matricule='.$matEtd);
                    while($arch_abs = $arch_ab->fetch()){
                        $databases->ReqSecure('INSERT INTO arch_absence(matricule,idMatiere,dateAbs,motif)
                        VALUES (:matricule,:matiere,:date,:motif)',
                        [
                            ':matricule' => $arch_abs['matricule'],
                            ':matiere' => $arch_abs['idMatiere'],
                            ':date' => $arch_abs['dateAbs'],
                            ':motif' => $arch_abs['motif']
                        ]);
                    }
                $arch_retard = $databases->requette('SELECT * FROM retard WHERE matricule='.$matEtd);
                    while($arch_retards = $arch_retard->fetch()){
                        $databases->ReqSecure('INSERT INTO arch_retard (matricule,idMatiere,heureEntrer,durer_retard,date,motif)
                        VALUES (:matricule,:matiere,:heure,:dure,:date,:motif)',
                           [
                               ':matricule' => $arch_retards['matricule'],
                               ':matiere' => $arch_retards['idMatiere'],
                               ':heure' => $arch_retards['heureEntrer'],
                               ':dure' => $arch_retards['durer_retard'],
                               ':date' => $arch_retards['date'],
                               ':motif' => $arch_retards['motif']
                           ]);
                    }
                
                $databases->requette('DELETE FROM ecolage WHERE matricule='.$matEtd);
                $databases->requette('DELETE FROM note WHERE matricule='.$matEtd);
                $databases->requette('DELETE FROM retard WHERE matricule='.$matEtd);
                $databases->requette('DELETE FROM absence WHERE matricule='.$matEtd);
            }
            $databases->requette('DELETE FROM etudiant WHERE idClasse='.$id);
            $databases->requette('DELETE FROM emploi_du_temp WHERE idClasse='.$id);
            $databases->requette('DELETE FROM classe WHERE idClasse='.$id);
            header('location: ../backend/Gpage.php?page=listeClasse&stat=1');
            
        }

    }
    if($_POST['btn'] === 'non'){
        if($_GET['action'] == 'delEtd'){
            header('location: ../backend/Gpage.php?page=listeEtud');
        }
        if($_GET['action'] == 'delClasse'){
            header('location: ../backend/Gpage.php?page=listeClasse');
        }
        if($_GET['action'] == 'delPay'){
            header('location: ../backend/Gpage.php?page=listePayement');
        }
        if($_GET['action'] == 'delFil'){
            header('location: ../backend/Gpage.php?page=LprofMat');
        }
        if($_GET['action'] === 'delMat'){
            header('location: ../backend/Gpage.php?page=LprofMat');
        }
        if($_GET['action'] === 'delProf'){
            header('location: ../backend/Gpage.php?page=Lprof');
        }
        if($_GET['action'] === 'delEmp'){
            header('location: ../backend/Gpage.php?page=emploiClasse&id='.$id);
        }
        if($_GET['action'] == 'archive'){
            header('location: ../backend/Gpage.php?page=listeClasse');
        }
    }
}
