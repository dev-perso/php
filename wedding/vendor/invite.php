<?php

class Invite
{
    private $bdd;
    private $name;
    private $present;
    private $boisson;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPresent()
    {
        return $this->present;
    }

    public function setPresent($present)
    {
        $this->present = $present;
    }

    public function getBoisson()
    {
        return $this->boisson;
    }

    public function setBoisson($boisson)
    {
        $this->boisson = $boisson;
    }

    public function getInvite($name)
    {
        $query = $this->bdd->prepare("SELECT id FROM invite WHERE name=?");
        $query->execute([$name]); 
        return $query->fetch();
    }

    public function addInvite()
    {
        if ($this->name == "" || $this->present == "")
        {
            return null;
        }
        else
        {
            //var_dump($this->getInvite($this->name)['id']);
            if ($this->getInvite($this->name) == false)
            {
                $this->bdd->exec(
                    "INSERT INTO
                        invite (id, name, present, boisson) 
                    VALUES
                        (NULL, '" . $this->name . "', '" . $this->present . "', '" . $this->boisson . "')"
                );
            }
        }
    }
}

?>