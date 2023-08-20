<?php
if(isset($_GET['cible'])){
    if($_GET['cible'] === 'note'){
        $page = 'AjoutNote';
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
    }
    if($_GET['cible'] === 'bulletin'){
        $page = 'bulletin';
        $id = '';
    }
    
}

?>
<div style="margin-top: 2.5cm;" class="container">
    <div class="jumbotron">
        <div class=" text-center form-group">
            <a href="../backend/Gpage.php?page=<?=$page?>&semestre=1&id=<?=$id?>" class="btn btn-success">Premier Semestre</a><br>
        </div>
        <div class=" text-center form-group">
            <a href="../backend/Gpage.php?page=<?=$page?>&semestre=2&id=<?=$id?>" class="btn btn-success">Deuxième Semestre</a>
        </div>
       
    </div>
</div> 