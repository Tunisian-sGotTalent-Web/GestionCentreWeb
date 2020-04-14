<?php


namespace CentreBundle\Entity;


use Symfony\Component\Validator\Constraints as Assert;

class CentreSearch
{

    /**
     * @var string

     */
private $nom;

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
}