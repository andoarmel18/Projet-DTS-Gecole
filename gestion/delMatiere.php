<?php
$idMatiere = (int)preg_quote($_GET['id']);
$databases->reqSecure('DELETE FROM matiere WHERE idMatiere=:idMat',[
    ':idMat' => $idMatiere
]);
header('location: ../backend/Gpage.php?page=LprofMat&stat=1');