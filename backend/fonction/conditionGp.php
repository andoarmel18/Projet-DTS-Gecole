<?php
function Gpage(string $pejy, string $lien)
{
    if($_GET['page'] === $pejy)
    {
    return include $lien;
    }
}