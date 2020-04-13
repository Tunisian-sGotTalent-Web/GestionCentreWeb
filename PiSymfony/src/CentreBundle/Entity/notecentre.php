<?php

namespace CentreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * notecentre
 *
 * @ORM\Table(name="notecentre")
 * @ORM\Entity(repositoryClass="NotecentreBundle\Repository\notecentreRepository")
 */
class notecentre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_centre", type="integer")
     */
    private $idCentre;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer")
     */
    private $idUser;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idCentre
     *
     * @param integer $idCentre
     *
     * @return notecentre
     */
    public function setIdCentre($idCentre)
    {
        $this->idCentre = $idCentre;

        return $this;
    }

    /**
     * Get idCentre
     *
     * @return int
     */
    public function getIdCentre()
    {
        return $this->idCentre;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return notecentre
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}

