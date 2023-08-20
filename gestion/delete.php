<?php
$databases->ReqSecure('DELETE FROM etudiant WHERE matricule = :mat' , 
[':mat' => $_GET['id']]);
header('location: ../backend/Gpage.php?page=listeEtud');
