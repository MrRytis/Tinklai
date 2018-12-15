<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="`user_lector`")
 * @ORM\Entity
 */
class User_lector
{
    /**
     * @ORM\Id;
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Userid", referencedColumnName="id")
     * })
     */
    private $fk_Userid;

    /**
     * @var \AppBundle\Entity\Modul
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Modul", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Modulid", referencedColumnName="id")
     * })
     */
    private $fkModulsid;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User_lector
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getFkUserid()
    {
        return $this->fk_Userid;
    }

    /**
     * @param User $fk_Userid
     * @return User_lector
     */
    public function setFkUserid($fk_Userid)
    {
        $this->fk_Userid = $fk_Userid;
        return $this;
    }

    /**
     * @return Modul
     */
    public function getFkModulsid()
    {
        return $this->fkModulsid;
    }

    /**
     * @param Modul $fkModulsid
     * @return User_lector
     */
    public function setFkModulsid($fkModulsid)
    {
        $this->fkModulsid = $fkModulsid;
        return $this;
    }


}