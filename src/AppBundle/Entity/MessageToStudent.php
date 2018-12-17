<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="`messageToStudent`")
 * @ORM\Entity
 */
class MessageToStudent
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
     * @var \AppBundle\Entity\User_student
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User_student", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Studentid", referencedColumnName="id")
     * })
     */
    protected $fk_Studentid;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $lector;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return MessageToStudent
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
     * @return MessageToStudent
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return User_student
     */
    public function getFkStudentid()
    {
        return $this->fk_Studentid;
    }

    /**
     * @param User_student $fk_Studentid
     * @return MessageToStudent
     */
    public function setFkStudentid($fk_Studentid)
    {
        $this->fk_Studentid = $fk_Studentid;
        return $this;
    }

    /**
     * @return string
     */
    public function getLector()
    {
        return $this->lector;
    }

    /**
     * @param string $lector
     * @return MessageToStudent
     */
    public function setLector($lector)
    {
        $this->lector = $lector;
        return $this;
    }




}