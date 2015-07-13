<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 7/11/2015
 * Time: 2:01 PM
 */

namespace Viktorija\VikaBudgetBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Viktorija\VikaBudgetBundle\Entity\BudgetUser;


/**
 * @ORM\Table(name="I_received")
 * @ORM\Entity(repositoryClass="Viktorija\VikaBudgetBundle\Entity\IncomeRepository")
 */
class Income {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $incomeType;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $picture;


    /**
     * @ORM\Column(type="decimal", scale=2, length=100)
     */
    private $total_this_week;

    /**
     * @ORM\Column(type="decimal", scale=2, length=100)
     */
    private $total_this_month;

    /**
     * @ORM\Column(type="integer", length=100)
     * @Assert\Type("\Date")
     */
    private $weekday;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIncomeType()
    {
        return $this->incomeType;
    }

    /**
     * @param mixed $incomeType
     */
    public function setIncomeType($incomeType)
    {
        $this->incomeType = $incomeType;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getTotalThisWeek()
    {
        return $this->total_this_week;
    }

    /**
     * @param mixed $total_this_week
     */
    public function setTotalThisWeek($total_this_week)
    {
        $this->total_this_week = $total_this_week;
    }

    /**
     * @return mixed
     */
    public function getTotalThisMonth()
    {
        return $this->total_this_month;
    }

    /**
     * @param mixed $total_this_month
     */
    public function setTotalThisMonth($total_this_month)
    {
        $this->total_this_month = $total_this_month;
    }

    /**
     * @return mixed
     */
    public function getWeekday()
    {
        return $this->weekday;
    }

    /**
     * @param mixed $weekday
     */
    public function setWeekday($weekday)
    {
        $this->weekday = $weekday;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Viktorija\VikaBudgetBundle\Entity\BudgetUser", inversedBy="income")
     * @ORM\JoinColumn(name="budgetUser_id", referencedColumnName="id")
     */
    protected $budgetUser;


    /**
     * Set budgetUser
     *
     * @param \Viktorija\VikaBudgetBundle\Entity\BudgetUser $budgetUser
     * @return Income
     */
    public function setBudgetUser(\Viktorija\VikaBudgetBundle\Entity\BudgetUser $budgetUser = null)
    {
        $this->budgetUser = $budgetUser;

        return $this;
    }

    /**
     * Get budgetUser
     *
     * @return \Viktorija\VikaBudgetBundle\Entity\BudgetUser 
     */
    public function getBudgetUser()
    {
        return $this->budgetUser;
    }
}
