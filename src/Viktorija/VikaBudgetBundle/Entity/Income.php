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

    /**
     * @ORM\OneToMany(targetEntity="Viktorija\VikaBudgetBundle\Entity\InDetail\IncomeInDetail", mappedBy="income")
     */
    protected $detailedIncome;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }


    /**
     * Add detailedIncome
     *
     * @param \Viktorija\VikaBudgetBundle\Entity\InDetail\IncomeInDetail $detailedIncome
     * @return Income
     */
    public function addDetailedIncome(\Viktorija\VikaBudgetBundle\Entity\InDetail\IncomeInDetail $detailedIncome)
    {
        $this->detailedIncome[] = $detailedIncome;

        return $this;
    }

    /**
     * Remove detailedIncome
     *
     * @param \Viktorija\VikaBudgetBundle\Entity\InDetail\IncomeInDetail $detailedIncome
     */
    public function removeDetailedIncome(\Viktorija\VikaBudgetBundle\Entity\InDetail\IncomeInDetail $detailedIncome)
    {
        $this->detailedIncome->removeElement($detailedIncome);
    }

    /**
     * Get detailedIncome
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetailedIncome()
    {
        return $this->detailedIncome;
    }
}
