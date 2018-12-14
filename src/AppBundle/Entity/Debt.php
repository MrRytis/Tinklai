<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 */
class Debt
{
    /**
     * @ORM\Id;
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $amount;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    protected $dateFrom;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    protected $dateTo;

    /**
     * @var \AppBundle\Entity\User_student
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User_student", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Studentid", referencedColumnName="id")
     * })
     */
    protected $fk_Studentid;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Debt
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Debt
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param \DateTime $dateFrom
     * @return Debt
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param \DateTime $dateTo
     * @return Debt
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
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
     * @return Debt
     */
    public function setFkStudentid($fk_Studentid)
    {
        $this->fk_Studentid = $fk_Studentid;
        return $this;
    }
}