<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="`messageToLector`")
 * @ORM\Entity
 */
class MessageToLector
{
    /**
     * @var integer
     *
     * @ORM\Id;
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=500)
     */
    protected $text;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $student;

    /**
     * @var \AppBundle\Entity\User_lector
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User_lector", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Lectorid", referencedColumnName="id")
     * })
     */
    protected $fk_Lectorid;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return MessageToLector
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return MessageToLector
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }


    /**
     * @return User_lector
     */
    public function getFkLectorid()
    {
        return $this->fk_Lectorid;
    }

    /**
     * @param User_lector $fk_Lectorid
     * @return MessageToLector
     */
    public function setFkLectorid($fk_Lectorid)
    {
        $this->fk_Lectorid = $fk_Lectorid;
        return $this;
    }

    /**
     * @return string
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param string $student
     * @return MessageToLector
     */
    public function setStudent($student)
    {
        $this->student = $student;
        return $this;
    }



}