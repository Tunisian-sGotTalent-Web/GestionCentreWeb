<?php

namespace CentreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Centre
 *
 * @ORM\Table(name="centre")
 * @ORM\Entity(repositoryClass="CentreBundle\Repository\CentreRepository")
 */
class Centre implements NotifiableInterface
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
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="nom_centre", type="string", length=255, nullable=true)
     */
    private $nomCentre;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="adresse_centre", type="string", length=255, nullable=true)
     */
    private $adresseCentre;

    /**
     * @var string
     * @ORM\Column(name="das_centre", type="string", length=255, nullable=true)
     */
    private $dasCentre;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email(checkMX=true)
     * @ORM\Column(name="mail_centre", type="string", length=255)
     */
    private $mailCentre;

    /**
     * @var int
     * @Assert\Range(min=200,max=500)
     *  @Assert\NotBlank()
     * @ORM\Column(name="telephone_centre", type="integer", nullable=true)
     */
    private $telephoneCentre;

    /**
     * @var string
     *
     * @ORM\Column(name="image_centre", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Ajouter une image")

     */
    private $imageCentre;

    /**
     * @var int
     *
     * @ORM\Column(name="vu_centre", type="integer", nullable=true)
     */
    private $vuCentre;


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
     * Set nomCentre
     *
     * @param string $nomCentre
     *
     * @return Centre
     */
    public function setNomCentre($nomCentre)
    {
        $this->nomCentre = $nomCentre;

        return $this;
    }

    /**
     * Get nomCentre
     *
     * @return string
     */
    public function getNomCentre()
    {
        return $this->nomCentre;
    }

    /**
     * Set adresseCentre
     *
     * @param string $adresseCentre
     *
     * @return Centre
     */
    public function setAdresseCentre($adresseCentre)
    {
        $this->adresseCentre = $adresseCentre;

        return $this;
    }

    /**
     * Get adresseCentre
     *
     * @return string
     */
    public function getAdresseCentre()
    {
        return $this->adresseCentre;
    }

    /**
     * Set dasCentre
     *
     * @param string $dasCentre
     *
     * @return Centre
     */
    public function setDasCentre($dasCentre)
    {
        $this->dasCentre = $dasCentre;

        return $this;
    }

    /**
     * Get dasCentre
     *
     * @return string
     */
    public function getDasCentre()
    {
        return $this->dasCentre;
    }
    /**
     * Set mailCentre
     *
     * @param string $mailCentre
     *
     * @return Centre
     */
    public function setMailCentre($mailCentre)
    {
        $this->mailCentre = $mailCentre;

        return $this;
    }

    /**
     * Get mailCentre
     *
     * @return string
     */
    public function getMailCentre()
    {
        return $this->mailCentre;
    }

    /**
     * Set telephoneCentre
     *
     * @param integer $telephoneCentre
     *
     * @return Centre
     */
    public function setTelephoneCentre($telephoneCentre)
    {
        $this->telephoneCentre = $telephoneCentre;

        return $this;
    }

    /**
     * Get telephoneCentre
     *
     * @return int
     */
    public function getTelephoneCentre()
    {
        return $this->telephoneCentre;
    }

    /**
     * Set imageCentre
     *
     * @param string $imageCentre
     *
     * @return Centre
     */
    public function setImageCentre($imageCentre)
    {
        $this->imageCentre = $imageCentre;
        return $this;
    }

    /**
     * Get imageCentre
     *
     * @return string
     */
    public function getImageCentre()
    {
        return $this->imageCentre;
    }

    /**
     * Set vuCentre
     *
     * @param integer $vuCentre
     *
     * @return Centre
     */
    public function setVuCentre($vuCentre)
    {
        $this->vuCentre = $vuCentre;

        return $this;
    }

    /**
     * Get vuCentre
     *
     * @return int
     */
    public function getVuCentre()
    {
        return $this->vuCentre;
    }

    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $notification=new Notification();
        $notification
            ->setTitle('hhhh')
            ->setDescription($this->nomCentre)
            ->setRoute('hhh')
            ->setParameters(array('id'=>$this->id));
        $builder->addNotification($notification);
        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification=new Notification();
        $notification
            ->setTitle('hhhh')
            ->setDescription($this->nomCentre)
            ->setRoute('hhh')
            ->setParameters(array('id'=>$this->id));
        $builder->addNotification($notification);
        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        return $builder;
    }

}


