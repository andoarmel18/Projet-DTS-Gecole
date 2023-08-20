
<nav class="navbar navbar-expand-md navbar-dark bg-primary">    
    <div class="collapse navbar-collapse" id="menuhamburger"> 
        <ul class="navbar-nav m-auto"> 
            <li <?php if($_GET['id']==="1") : echo 'class="nav-item active"'; endif?>> 
                <a href="../backend/Gpage.php?page=listePayement&id=1" class="nav-link">1ere Année</a> 
            </li> 
            <li <?php if($_GET['id']==="2") : echo 'class="nav-item active"'; endif?>> 
                <a href="../backend/Gpage.php?page=listePayement&id=2" class="nav-link">2ème Années</a> 
            </li> 
            <li <?php if($_GET['id']==="3") : echo 'class="nav-item active"'; endif?>> 
                <a href="../backend/Gpage.php?page=listePayement&id=3" class="nav-link">3ème Années</a> 
            </li> 
            <li <?php if($_GET['id']==="4") : echo 'class="nav-item active"'; endif?>> 
                <a href="../backend/Gpage.php?page=listePayement&id=4" class="nav-link">4ème Années</a> 
            </li>
            <li <?php if($_GET['id']==="5") : echo 'class="nav-item active"'; endif?>> 
                <a href="../backend/Gpage.php?page=listePayement&id=5" class="nav-link">5ème Années</a> 
            </li>
        </ul> 
    </div> 
</nav>