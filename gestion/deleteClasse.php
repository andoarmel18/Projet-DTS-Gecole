<?php
$databases->ReqSecure('DELETE FROM classe WHERE idClasse = :id' , 
[':id' => $_GET['id']]);
header('location: ../backend/Gpage.php?page=listeClasse');
