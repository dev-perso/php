<?php

class DataBase
{
    private $bdd;

    public function __construct($config)
    {
        try
        {
            $this->bdd = new PDO ('mysql:host=' . $config->getHost() . ';dbname=' . $config->getDbname(),
                                  $config->getUser(),
                                  $config->getPassword());  
        }
        catch (PDOException $e)
        {
            return 'Connexion échouée : ' . $e->getMessage();
        }
    }

    public function getBdd()
    {
        return $this->bdd;
    }
}

?>