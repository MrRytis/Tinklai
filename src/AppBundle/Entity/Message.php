<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="`message`")
 * @ORM\Entity
 */
class Message
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
     * @ORM\Column(type="string", length=255)
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Message
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
     * @return Message
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
     * @return Message
     */
    public function setFkStudentid($fk_Studentid)
    {
        $this->fk_Studentid = $fk_Studentid;
        return $this;
    }


}