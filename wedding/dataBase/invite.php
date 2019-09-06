<?php

function connectAtscaf($config)
{
    try {
        return new PDO('mysql:host=' . $config->getHost() . ';dbname=' . $config->getDbname(), 'paris', 'Kukish54');  
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
    }
        
}

if (isset($_POST['name']) && isset($_POST['present']) && isset($_POST['boisson']))
{
    $bdd = connectAtscaf($config);
    $bdd->exec("INSERT INTO invite (id, name, present, boisson) VALUES(NULL, '" . $_POST['name'] . "', '" . $_POST['present'] . "', '" . $_POST['boisson'] . "')");
}

?>