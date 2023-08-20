<?php
$idActionProf = (int)$_GET['id'];
$stat= $databases->requette('DELETE FROM profmat WHERE idProfMat='.$idActionProf);
if($stat){
    header('location: ../backend/Gpage.php?page=action');
}