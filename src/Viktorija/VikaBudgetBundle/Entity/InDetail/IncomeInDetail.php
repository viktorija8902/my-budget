<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 7/27/2015
 * Time: 3:54 PM
 */

namespace Viktorija\VikaBudgetBundle\Entity\InDetail;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="All_income_in_detail")
 * @ORM\Entity(repositoryClass="Viktorija\VikaBudgetBundle\Entity\InDetail\ExpensesInDetailRepository")
 */
class IncomeInDetail {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $receivedAmount;

    /**
     * @ORM\Column(type="integer")
     */
    private $dateAdded;

    /**
     * @ORM\Column(type="integer")
     */
    private $weekOfYear;

    /**
     * @ORM\Column(type="integer")
     */
    private $monthOfYear;

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
    public function getReceivedAmount()
    {
        return $this->receivedAmount;
    }

    /**
     * @param mixed $receivedAmount
     */
    public function setReceivedAmount($receivedAmount)
    {
        $this->receivedAmount = $receivedAmount;
    }


    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param mixed $dateAdded
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
    }

    /**
     * @return mixed
     */
    public function getWeekOfYear()
    {
        return $this->weekOfYear;
    }

    /**
     * @param mixed $weekOfYear
     */
    public function setWeekOfYear($weekOfYear)
    {
        $this->weekOfYear = $weekOfYear;
    }

    /**
     * @return mixed
     */
    public function getMonthOfYear()
    {
        return $this->monthOfYear;
    }

    /**
     * @param mixed $monthOfYear
     */
    public function setMonthOfYear($monthOfYear)
    {
        $this->monthOfYear = $monthOfYear;
    }


    /**
     * @ORM\ManyToOne(targetEntity="Viktorija\VikaBudgetBundle\Entity\Income", inversedBy="detailedIncome")
     * @ORM\JoinColumn(name="income_group_id", referencedColumnName="id")
     */
    protected $income;





    /**
     * Set income
     *
     * @param \Viktorija\VikaBudgetBundle\Entity\Income $income
     * @return IncomeInDetail
     */
    public function setIncome(\Viktorija\VikaBudgetBundle\Entity\Income $income = null)
    {
        $this->income = $income;

        return $this;
    }

    /**
     * Get income
     *
     * @return \Viktorija\VikaBudgetBundle\Entity\Income 
     */
    public function getIncome()
    {
        return $this->income;
    }
}
