<?php

class Config
{
    private $config;
    private $logo;
    private $date;
    private $host;
    private $dbname;
    private $user;
    private $password;

    public function __construct()
    {
        $config = parse_ini_file(ROOT_CONFIG, true);
        
        $this->logo = $config['INFO']['logo'];
        $this->date = $config['INFO']['date'];
        
        $this->host = $config['BDD']['host'];
        $this->dbname = $config['BDD']['dbname'];
        $this->user = $config['BDD']['user'];
        $this->password = $config['BDD']['password'];
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getDbname()
    {
        return $this->dbname;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }
}

?>