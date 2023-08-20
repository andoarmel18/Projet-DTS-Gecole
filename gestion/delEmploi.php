<?php
$idEmploi = (int)preg_quote($_GET['id']);
$databases->reqSecure('DELETE FROM emploi_du_temp WHERE idClasse=:id',
[
    ':id' => $idEmploi
]);
header('location: ../backend/Gpage.php?page=creerEdt');